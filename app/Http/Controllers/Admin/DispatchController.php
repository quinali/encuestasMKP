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

		$nLlamadasTot =  DB::table('tokens_'.$sid)->count();

		$nLlamadasPendientes=DB::table('tokens_'.$sid)
								->whereBetween('tid',[$desde,$hasta])
								->where('completed','N')
								->orderBy('tid', 'asc')
								->count();
						

		if($hasta>$nLlamadasTot) 
			$hasta = $nLlamadasTot;
		
		if($desde > $hasta)
			return Redirect::to('survey/'.$sid.'/dispatch')->with('status', 'El limite inferior no puede ser mayor que el limite superior.');
		
		log::Debug("Reasignando desde la ".$desde." hasta la ".$hasta);
		
		$this->liberarLlamadas($sid,$desde,$hasta);
		
		//Recupero las llamadas pendientes
		$llamadasTotales =  DB::table('tokens_'.$sid)
								->whereBetween('tid',[$desde,$hasta])
								->orderBy('tid', 'asc')
								->get();
						
		$nOperadores =  DB::table('survey_operators')
							->where('idSurvey',$sid)
							->count();												

		$operadores =  DB::table('survey_operators')
								->where('idSurvey',$sid)
								->get();						

		
		$nLlamadasPorOperador = $nLlamadasPendientes / $nOperadores;

		$idToken = 1;
		$idOperador=0;
		log::debug('$idOperador='.$idOperador);

		log::info ("Encuesta[".$sid."]: Repartimos ".$nLlamadasPendientes." (desde la ".$desde." hasta la ".$hasta.")llamadas entre ".$nOperadores." operadores, a ".$nLlamadasPorOperador." llamadas por operador.");

		//Recorremos todas las llamadas entre DESDE y HASTA
		var_dump($operadores);


		foreach ($llamadasTotales as $llamada ) {
			
			log::debug('$idToken='.$idToken);
			log::debug('$llamada->tid='.$llamada->tid);
			log::debug('$idOperador='.$idOperador);

			

			if($llamada->completed=='N'){

				if($idToken > (($idOperador+1) * $nLlamadasPorOperador) )
				{
					log::debug('Cambiamos de operador');	
					$idOperador++;
				}

				log::debug('$operadores[$idOperador]->idOperator='.$operadores[$idOperador]->idOperator);

				log::debug($idToken."----->".$llamada->tid.":".$operadores[$idOperador]->idOperator);

				DB::table('tokens_'.$sid)
					->where('tid',$llamada->tid)
					->update(['attribute_1'=>$operadores[$idOperador]->idOperator]);

				$idToken++;
			}
			
		}						

		return Redirect::to('survey/'.$sid)->with('status', 'Proceso de reasignación de llamadas, realizado correctamente');
	}


	public function recover(Request $request,$sid)
	{	
		$desde=$request->input('desde');
		$hasta=$request->input('hasta');


		if($desde <0){
			$desde=1;
		}

		$nLlamadasTot =  DB::table('tokens_'.$sid)->count();

		if($hasta>$nLlamadasTot) 
			$hasta = $nLlamadasTot;
		
		if($desde > $hasta)
			return Redirect::to('survey/'.$sid.'/dispatch')->with('status', 'El limite inferior no puede ser mayor que el limite superior.');
		
		log::info('['.$sid.'] Recueperamos las llamadas de el token '.$desde.' hasta el '.$hasta);

		$rellamadaColumn = $sid.'X'.SettingsController::getAnwswerGroup($sid).'X'.SettingsController::getRellamadaAnswer($sid);			

		$sqlTokensRecuperables=	" select tid,token from tokens_".$sid." where token in ".
								" ( ".
								" 	select maxTable.token ".
								" 	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
								" 	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
								" 	where `".$rellamadaColumn."`='A1' ".
								"  ) and tokens_".$sid.".completed<>'N'".
								" and tid between ".$desde." and ".$hasta;
		
		$tokensRecuperables = DB::select($sqlTokensRecuperables);		

		foreach( $tokensRecuperables as $tokenRecuperable){

			//Recuperamos cada llamada
			LlamadasController::recover($sid,$tokenRecuperable->tid);

		}

		return Redirect::to('survey/'.$sid)->with('status', 'Proceso de recuperacion de llamadas, realizado correctamente');						
	}

	public function deallocate(Request $request,$sid){

		$desde=$request->input('desde');
		$hasta=$request->input('hasta');


		if($desde <0){
			$desde=1;
		}

		$nLlamadasTot =  DB::table('tokens_'.$sid)->count();

		if($hasta>$nLlamadasTot) 
			$hasta = $nLlamadasTot;
		
		if($desde > $hasta)
			return Redirect::to('survey/'.$sid.'/dispatch')->with('status', 'El limite inferior no puede ser mayor que el limite superior.');

		log::info('['.$sid.'] Eliminamos la asigancion desde el token '.$desde.' hasta el '.$hasta);
		$this->liberarLlamadas($sid,$desde,$hasta);


		return Redirect::to('survey/'.$sid)->with('status', 'Eliminada la asignación de llamadas pendientes.');	

	}


	private function liberarLlamadas($sid,$desde,$hasta){

		DB::table('tokens_'.$sid)
			->where('completed','N')
			->whereBetween('tid',[$desde,$hasta])
			->update(['attribute_1'=>null]);
	}		

}
