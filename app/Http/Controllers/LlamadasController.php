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
	
   public function __construct()
	{
		$this->numResultaPerPag = env('NUMRESULTAPERPAG', '20');
		$this->middleware('auth');
	}
	
	
	public function index(Request $request,$sid)
	{
		$page = $request->input('page');
		$nameFilter = $request->input('nameFilter');
		$telFilter = $request->input('telFilter');
		$recuperarLlamadas = $request->input('recuperar');
		
		$isConfirmacion=DB::Table('plugin_settings')
						->where('key',$sid)
						->select('isConfirmation')
						->first();

		//Filtro para componer las busquedas de llamadas				
		$callFilter =array();
		$callFilter["nameFilter"]=$nameFilter;
		$callFilter["telFilter"]=$telFilter;
		$callFilter["isConfirmacion"]=$isConfirmacion;
		//$callFilter["recuperarLlamadas"]=$recuperarLlamadas;
		$callFilter["recuperarLlamadas"]=1;
		
		
		//Validamos que $sid es un numero
		$validator = Validator::make(
			array('sid' => $sid),
			array('sid' => array('numeric'))
		);
		
		if ($validator->fails())
		{
			Log::info('[ERROR] LlamadasController: Se ha producido error en la validacion de ('.$sid.')');
			return Redirect::to('encuestas')->with('status', '¡Se ha producido un error!');
		}
	
		$contadoresLlamadas=$this->getContadoresLlamadas($sid, Auth::user()->id);
		
		$totalLlamadasMostradas = $this->getLlamadasTotals ($sid, Auth::user()->id, $callFilter);
		
		$totalPages = ceil($totalLlamadasMostradas->totalMostradas / $this->numResultaPerPag);
		
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
		
		//Si estamos filtrando y paginamos metemos el filtro en cada URL de la paginacion
		$filterQuery='';
		
		if(isset($nameFilter) and $nameFilter !='')
			$filterQuery.='&nameFilter='.$nameFilter;
		
		if(isset($telFilter) and $telFilter !='')
			$filterQuery.='&telFilter='.$telFilter;
		
		
		//Por ultimo sacamos la informacion de las llamadas, siempre que existan resultados
		if($totalLlamadasMostradas->totalMostradas >0){
			$llamadas=$this->getLlamadas($sid, Auth::user()->id, $page , $callFilter);
		}else {
			$llamadas= array();
		}
		
		
		$data = array();
		$data['sid']=$sid;
		$data['surveyTitle']=$surveyTitle;
		$data['totalPages']=$totalPages;
		$data['filterQuery']=$filterQuery;
		$data['isConfirmacion']=$isConfirmacion->isConfirmation;
		$data['page']=$page;
		$data['contadoresLlamadas'] = $contadoresLlamadas;
		$data['llamadas'] = $llamadas;
		$data['nameFilter'] = $nameFilter;
		$data['telFilter'] = $telFilter;
		
		//print_r($totalLlamadas);
		
		return view('llamadas',['data' => $data]);
	}
	
	
	
	//Reseteamos la llamada y recargamos la pagina
	public static function recover($sid,$tid){
		
		$tokenRecuperable=DB::Table('tokens_'.$sid)
							->where('tid', $tid)
							->first();

		$attRecargables=LlamadasController::getAttRecargables($sid);
		
		$selectSQL='';
		
		$updatedValues=array();
		$updatedValues['completed']='N';
		
		if(sizeof($attRecargables) != 0){

			$firstElement=true;

			foreach ($attRecargables as $key => $value) {

				if(!$firstElement)
					$selectSQL .=',';
				else
					$firstElement=false;
							
				$selectSQL .='`'.$value.'` as '.$key;
			}


			$sqlUltimosDatosRegistrados=	" select ".$selectSQL.
							" from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
							" inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
							" where maxTable.token='".$tokenRecuperable->token."'";
	
			$rsUpdatedValues = DB::select($sqlUltimosDatosRegistrados)[0];

			var_dump($rsUpdatedValues);

			
			foreach ($attRecargables as $key => $value) {
				$updatedValues[$key]=$rsUpdatedValues->$key;
			}

						
		}					


		//Actualizo el token recibido
		DB::table( 'tokens_'.$sid)
            ->where('tid', $tid)
            ->update($updatedValues);
	}

	public function rellamar(Request $request,$sid,$tid){

		$this->recover($sid,$tid);
		
		//Si se hace rellamada en pagina filtrada, compongo los parametros
		$page = $request->input('page');
		$nameFilter = $request->input('nameFilter');
		$telFilter = $request->input('telFilter');
		
		$queryParam = '?';
		$querySet = false;
		
		
		if(isset($page)){
			$queryParam.='page='.$page;
			$querySet = true;
		}
		if(isset($nameFilter)){
			$queryParam.='&nameFilter='.$nameFilter;
			$querySet = true;
		}
		if(isset($telFilter)){
			$queryParam.='&telFilter='.$telFilter;
			$querySet = true;
		}
		
		//Si no querySet borro el contenido
		if(!$querySet){
			$queryParam="";
		}
	
		//Redirijo a llamadas
		//return Redirect::to('llamadas/'.$sid.'#'.$tid)->with('status', '¡Llamada recuperada con éxito!');
		return Redirect::to('llamadas/'.$sid.$queryParam.'#'.$tid)->with('status', '¡Llamada recuperada con éxito!');
	}	
	
	public function getContadoresLlamadas($sid,$idOperador)
	{
		$sqlTotalCount ="SELECT ".
						"(SELECT surveyls_title FROM surveys_languagesettings WHERE surveyls_survey_id =".$sid.") as tituloEncuesta,".
						"(SELECT count(1) FROM `tokens_".$sid."` WHERE `attribute_1` ='".$idOperador."' and completed='N') as totalPtes,".
						"(SELECT count(1) FROM `tokens_".$sid."` WHERE `attribute_1` ='".$idOperador."' and completed<>'N' ) as totalEmitidas,".
						"(SELECT count(1) FROM `tokens_".$sid."` WHERE `attribute_1` ='".$idOperador."') as totalAsignadas" ;
						
		return DB::select($sqlTotalCount)[0];
	}
	
	
	public function getLlamadasTotals($sid,$idOperador, $callFilter)
	{
		$sqlTotalCount = "SELECT count(1) as totalMostradas FROM `tokens_".$sid."` WHERE `attribute_1` ='".$idOperador."' " ;
		
		//Introducimos los filtros si hace falta
		if(isset($callFilter['nameFilter']) and $callFilter['nameFilter'] !=''){
			//$sqlNameFilter =" AND (firstname LIKE '%".$callFilter['nameFilter']."%' OR lastname LIKE '%".$callFilter['nameFilter']."%' )";
			$sqlNameFilter =" AND CONCAT(firstname,' ',lastname) LIKE '%".$callFilter['nameFilter']."%'";
			$sqlTotalCount.= $sqlNameFilter;
		}
		
		$isConfirmacion = get_object_vars ($callFilter['isConfirmacion']);
		
		if(isset($callFilter['telFilter']) and $callFilter['telFilter'] !=''){
			
			//Dependiendo de si es de confirmacion o no, buscamos en unos campos de token u otros
			//if ($isConfirmacion = 0){
			//	$sqlTelFilter = " AND (attribute_3 LIKE '".$callFilter['telFilter']."%' OR attribute_4 LIKE '".$callFilter['telFilter']."%') ";
			//}else{
			//	$sqlTelFilter = " AND (attribute_4 LIKE '".$callFilter['telFilter']."%' OR attribute_5 LIKE '".$callFilter['telFilter']."%') ";
			//}
		
			//Como no se marcan todas las encuestas de confirmacion, buscamos tel en att3,att4 y att5
			$sqlTelFilter = " AND (attribute_3 LIKE '".$callFilter['telFilter']."%' OR attribute_4 LIKE '".$callFilter['telFilter']."%' OR attribute_5 LIKE '".$callFilter['telFilter']."%') ";

			$sqlTotalCount.= $sqlTelFilter;		
		}	

		
		return DB::select($sqlTotalCount)[0];
	}
	
	public function getLlamadas( $sid, $idOperador, $page, $callFilter)
	{

		//Log::info("getLlamadas()--->nameFilter=".print_r($callFilter, true));
		
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
					" LEFT JOIN survey_".$sid." srv on maxIDTable.maxid = srv.id ".
					" LEFT JOIN answers anws on (anws.qid=".$recallField['anws_qid']." and srv.`".$recallField['anws_code']."` = anws.code)".
					" WHERE tok.attribute_1='".$idOperador."' ";
		
		if(isset($callFilter['nameFilter']) and $callFilter['nameFilter'] !=''){
			//$sqlNameFilter =" AND (tok.firstname LIKE '%".$callFilter['nameFilter']."%' OR tok.lastname LIKE '%".$callFilter['nameFilter']."%' )";
			$sqlNameFilter =" AND CONCAT(tok.firstname,' ',tok.lastname) LIKE '%".$callFilter['nameFilter']."%'";
			$sqlToken.= $sqlNameFilter;
		}
		
		
		//Si solo visualizamos las recuperables, lo metemos en el filtro
		//$llamada->CONTACT === 'N' and $llamada->MOTIV === 'A1') OR ($llamada->CONTACT === 'A2' and $llamada->MOTIV ==='A1'
		if(isset($callFilter['recuperarLlamadas']) and $callFilter['recuperarLlamadas']==1){
			$sqlToken.=" AND (srv.`".$recallField['contact']."`='A2' AND  srv.`".$recallField['motiv']."`='A1' ) ";
		}
		
		$isConfirmacion = get_object_vars ($callFilter['isConfirmacion']);
		
		if(isset($callFilter['telFilter']) and $callFilter['telFilter'] !=''){
			
			//Dependiendo de si es de confirmacion o no, buscamos en unos campos de token u otros
			//if ($isConfirmacion == 0){
			//	$sqlTelFilter = " AND (tok.attribute_3 LIKE '".$callFilter['telFilter']."%' OR tok.attribute_4 LIKE '".$callFilter['telFilter']."%') ";
			//}else{
			//	$sqlTelFilter = " AND (tok.attribute_4 LIKE '".$callFilter['telFilter']."%' OR tok.attribute_5 LIKE '".$callFilter['telFilter']."%') ";
			//}

			//Como no se marcan todas las encuestas de confirmacion, buscamos tel en att3,att4 y att5
			$sqlTelFilter = " AND (attribute_3 LIKE '".$callFilter['telFilter']."%' OR attribute_4 LIKE '".$callFilter['telFilter']."%' OR attribute_5 LIKE '".$callFilter['telFilter']."%') ";
		
			$sqlToken.= $sqlTelFilter;		
		}		
				
		
		//Al final incluimos la zona de ordenacion		
		$sqlOrder=	" ORDER by tok.tid LIMIT ".$startCall.",".$this->numResultaPerPag;
		$sqlToken.= $sqlOrder;
		
		Log::info('SQL: getLlamadas() ->'.$sqlToken);
				
		$llamadas = DB::select($sqlToken);	
		
		return $llamadas;
		//return view('llamadasadmin/console' , ['surveys' => $surveys,'filterName'=>$filterName]);	
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

	
	public static function getAttRecargables($sid){

		$attributedescriptions=json_decode(DB::table('surveys')
        ->where('sid', $sid)  
        ->select('attributedescriptions')
        ->first()
		->attributedescriptions) ;				

		$attRecargables = [];
      
        foreach ($attributedescriptions as $key => $value) {
        	if($value->cpdbmap != '(ninguno)' && ($value->cpdbmap != null) )
				$attRecargables[$key]=$value->cpdbmap;
        }

        return $attRecargables;
	}
	
}
