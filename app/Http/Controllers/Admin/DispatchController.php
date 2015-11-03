<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LlamadasController;

use DB;
use Log;
use Auth;
use Redirect;


class DispatchController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
		$this ->middleware('check.admin');
	}
	
	
	public function index($sid)
	{
		$surveys_languagesettings = DB::table('surveys_languagesettings')
									->where('surveyls_survey_id',$sid)
									->first();
		
		$nLlamadasPendientes =  DB::table('tokens_'.$sid)
								->where('completed','N')
								->count();

		$data = array();
		
		$data['sid']=$sid;
		$data['survey_title']=$surveys_languagesettings->surveyls_title;
		$data['nLlamadasPendientes']=$nLlamadasPendientes;
		
		
		return view('admin/dispatch',['data' => $data]);	
		
	}


	public function reassign (Request $request, $sid)
	{

		$desde=$request->input('desde');
		$hasta=$request->input('hasta');

		if($desde <0){
			$desde=1;
		}


		$nLlamadasPendientes =  DB::table('tokens_'.$sid)
								->where('completed','N')
								->count();

		if($hasta>$nLlamadasPendientes) 
			$hasta = $nLlamadasPendientes;
		
		if($desde > $hasta)
			return Redirect::to('survey/'.$sid.'/dispatch')->with('status', 'El limite inferior no puede ser mayor que el limite superior.');
		
		log::Debug("Reasignando desde la ".$desde." hasta la ".$hasta);
		
		$this->liberarLlamadas($sid);
		
		//Recupero las llamadasd pendientes
		$llamadasPendientes =  DB::table('tokens_'.$sid)
								->where('completed','N')
								->skip($desde)
								->take($hasta-$desde)
								->orderBy('tid', 'asc')
								->get();
	
		DB::connection()->enableQueryLog();	
		$nLlamadasPendientes =  count($llamadasPendientes);
							
		$nOperadores =  DB::table('survey_operators')
							->where('idSurvey',$sid)
							->count();												

		$operadores =  DB::table('survey_operators')
								->where('idSurvey',$sid)
								->get();						

		$nLlamadasPorOperador = $nLlamadasPendientes / $nOperadores;

		$idToken = 1;
		$idOperador=1;
		
		log::info ("Encuesta[".$sid."]: Repartimos ".$nLlamadasPendientes." (desde la ".$desde." hasta la ".$hasta.")llamadas entre ".$nOperadores." operadores, a ".$nLlamadasPorOperador." llamadas por operador.");

		foreach ($llamadasPendientes as $llamadaPendiente ) {

			if($idToken > ($idOperador * $nLlamadasPorOperador) )
			{
				$idOperador++;
			}

			log::debug($idToken."----->".$llamadaPendiente->tid.":".$operadores[$idOperador-1]->idOperator);

			DB::table('tokens_'.$sid)
				->where('tid',$llamadaPendiente->tid)
				->update(['attribute_1'=>$operadores[$idOperador-1]->idOperator]);

			$idToken++;
		}						

		return Redirect::to('survey/'.$sid)->with('status', 'Proceso de reasignación de llamadas, realizado correctamente');
	}


	public function recover($sid)
	{

		$rellamadaColumn = $sid.'X'.SettingsController::getAnwswerGroup($sid).'X'.SettingsController::getRellamadaAnswer($sid);			

		$sqlTokensRecuperables=	" select tid,token from tokens_".$sid." where token in ".
								" ( ".
								" 	select maxTable.token ".
								" 	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
								" 	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
								" 	where `".$rellamadaColumn."`='A1' ".
								"  ) and tokens_".$sid.".completed<>'N'";
		
		$tokensRecuperables = DB::select($sqlTokensRecuperables);		

		foreach( $tokensRecuperables as $tokenRecuperable){

			//Recuperamos cada llamada
			LlamadasController::recover($sid,$tokenRecuperable->tid);

		}

		return Redirect::to('survey/'.$sid)->with('status', 'Proceso de recuperacion de llamadas, realizado correctamente');						
	}

	public function deallocate($sid){

		$this->liberarLlamadas($sid);
		return Redirect::to('survey/'.$sid)->with('status', 'Eliminada la asignación de llamadas pendientes.');	
	}


	private function liberarLlamadas($sid){

		DB::table('tokens_'.$sid)
			->where('completed','N')
			->update(['attribute_1'=>null]);
	}		

}
