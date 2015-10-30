<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SettingsController;
use DB;
use Log;
use Auth;
use Redirect;
use Session;
use Validator;

class LlamadasController extends Controller
{
	protected $numResultaPerPag;
	protected $encuestasRellamada;
	
   public function __construct()
	{
		
				
		$this->numResultaPerPag = env('NUMRESULTAPERPAG', '20');
		$this->encuestasRellamada = explode(',', env('ENCUESTAS_RELLAMADA', ''));
		$this->middleware('auth');
	}
	
	
	public function index(Request $request,$sid)
	{
		
		$isConfirmacion=FALSE;
		
		if(in_array($sid,$this->encuestasRellamada)){
			$isConfirmacion=TRUE;
		}
		
		//Validamos que $sid es un numero
		$validator = Validator::make(
			array('sid' => $sid),
			array('sid' => array('numeric'))
		);
		
		if ($validator->fails())
		{
			Log::info('------------------------->Se ha producido error en la validacion ('.$sid.')');
			return Redirect::to('encuestas')->with('status', '¡Se ha producido un error!');
		}

	
		$totalLlamadas=$this->getLlamadasTotals($sid, Auth::user()->id );
		$totalPages = ceil($totalLlamadas->totalAsignadas / $this->numResultaPerPag);
		
		$page = $request->input('page');
		
		if(!isset($page)){
			if(!Session::has('page')){	
				$page=0;
			}else{
				$page=Session::get('page');
			}
		}else{
			// Convert the page number to an integer
			$page = (int)$page;
		}
		// If the page number is less than 1, make it 1.
		if($page <1){
			$page = 1;
		// Check that the page is below the last page
		}else if ($page > $totalPages){
			$page = $totalPages;
		}
		
		//Store $page in session
		Session::put('page', $page);
		
		$surveyTitle=DB::Table('surveys_languagesettings')
						->where('surveyls_survey_id',$sid)
						->select('surveyls_title')
						->first()->surveyls_title;

		
		Log::info('LlamadasController::index('.$sid.','.Auth::user()->id.',page='.$page.')');
		$llamadas=$this->getLlamadas($sid, Auth::user()->id, $page , $this->numResultaPerPag);
		
		//var_dump($surveyTitle);

		$data = array();
		$data['sid']=$sid;
		$data['surveyTitle']=$surveyTitle;
		$data['totalPages']=$totalPages;
		$data['isConfirmacion']=$isConfirmacion;
		$data['page']=$page;
		$data['totalLlamadas'] = $totalLlamadas;
		$data['llamadas'] = $llamadas;
		
		//print_r($totalLlamadas);
		
				
		return view('llamadas',['data' => $data]);	
		
	}
	
	
	
	//Reseteamos la llamada y recargamos la pagina
	public static function recover($sid,$tid){
		
		$tokenRecuperable=DB::Table('tokens_'.$sid)
							->where('tid', $tid)
							->first();

		//Sacamos la ultima observacion
		$sqlUltimaObs=	" select sv.`".SettingsController::getObservacionesAnswerColumn($sid)."` as observaciones ".
							" from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
							" inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
							" where maxTable.token='".$tokenRecuperable->token."'";

		$ultimaObs = DB::select($sqlUltimaObs)[0]->observaciones;			

		log::debug("Vamos a recuperar el token ".$tid." y le vamos a poner la obs:".$ultimaObs);
		
		//Actualizo el token recibido
		DB::table( 'tokens_'.$sid)
            ->where('tid', $tid)
            ->update(['completed' => 'N',
            		  'attribute_2' => $ultimaObs]);
		
	}

	public function rellamar($sid,$tid){

		$this->recover($sid,$tid);

		//Redirijo a llamadas
		return Redirect::to('llamadas/'.$sid.'#'.$tid)->with('status', '¡Llamada recuperada con éxito!');

	}
	
	
	public function getLlamadasTotals($sid,$idOperador)
	{
		$sqlTotalCount ="SELECT ".
						"(SELECT surveyls_title FROM surveys_languagesettings WHERE surveyls_survey_id =".$sid.") as tituloEncuesta,".
						"(SELECT count(1) FROM `tokens_".$sid."` WHERE `attribute_1` ='".$idOperador."' and completed='N') as totalPtes,".
						"(SELECT count(1) FROM `tokens_".$sid."` WHERE `attribute_1` ='".$idOperador."' and completed<>'N' ) as totalEmitidas,".
						"(SELECT count(1) FROM `tokens_".$sid."` WHERE `attribute_1` ='".$idOperador."') as totalAsignadas" ;

		return DB::select($sqlTotalCount)[0];
	
	}
	
	
	public function getLlamadas( $sid, $idOperador, $page)
	{

		$recallField=$this->getRecallConfig($sid);
		
		$startCall = ($page - 1) * $this->numResultaPerPag;
		
		
		$sqlToken=	"SELECT ".
					"tok.tid,tok.firstname,tok.lastname,".
					"tok.token,tok.attribute_3,tok.attribute_4,tok.attribute_5,".
					"tok.completed,tok.usesleft as intentos,".
					" srv.`".$recallField['contact']."` as CONTACT,".
					" srv.`".$recallField['motiv']."` as MOTIV ".
					", anws.answer ".
					" from tokens_".$sid." tok ".
					" left join ( ".
					"    select srvMax.token, max(srvMax.id) as maxid ".
					"      from survey_".$sid." srvMax ".
					"    group by srvMax.token) as maxIDTable  on tok.token=maxIDTable.token".
					" left join survey_".$sid." srv on maxIDTable.maxid = srv.id ".
					" left join answers anws on (anws.qid=".$recallField['anws_qid']." and srv.`".$recallField['anws_code']."` = anws.code)".
					" where tok.attribute_1='".$idOperador."' order by tok.tid ".
					" LIMIT ".$startCall.",".$this->numResultaPerPag;
		
		log::debug($sqlToken);			

		$llamadas = DB::select($sqlToken);	
		
		return $llamadas;
	
	}
	
	
	
	public function getRecallConfig($sid){
	
		$recallFieldData = array();

		$gid = SettingsController::getAnwswerGroup($sid);

		$tablePrefix = $sid.'X'.$gid.'X';

		$recallFieldData['anws_qid']=SettingsController::getMotivoRellamarAnswer($sid);
		
		$recallFieldData['contact']=$tablePrefix.SettingsController::getHaConstactadoAnswer($sid);
		
		$recallFieldData['motiv']=$tablePrefix.SettingsController::getRellamadaAnswer($sid);
		
		$recallFieldData['anws_code']=$tablePrefix.SettingsController::getMotivoRellamarAnswer($sid);
		
		return $recallFieldData;
		
	}
	
}
