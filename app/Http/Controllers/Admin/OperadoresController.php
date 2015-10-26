<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;
use Redirect;

class OperadoresController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
	}
	
	
	public function index($sid)
	{
		log::debug("Entrando en zona de administracion de operadores de la encuesta ".$sid);
		
		$surveys_languagesettings = DB::table('surveys_languagesettings')
					->where('surveyls_survey_id',$sid)
					->first();

		$opIdAsignados = DB::table('survey_operators')
					->where('idSurvey',$sid)
					->lists('idOperator');

		$opAsignados = DB::table('survey_operators')
					->join('usuarios_operadores', 'survey_operators.idOperator', '=', 'usuarios_operadores.id')
					->where('idSurvey',$sid)
					->orderBy('order','asc')
					->get();			


		$usuarios_administradores= DB::table('usuarios_operadores')
					->where('isAdmin',TRUE)
					->get();			

	

		$arrayUsersAdmin = array();
		foreach ($usuarios_administradores as $usuario_admin) {
					array_push ($arrayUsersAdmin,$usuario_admin->id);
		}

		$opPosibles = DB::table('usuarios_operadores')
					->whereNotIn('id',$opIdAsignados)
					->whereNotIn('id',$arrayUsersAdmin)
					->orderBy('order','asc')
					->get();

		$data = array();

		$data['sid']=$sid;
		$data['survey_title']=$surveys_languagesettings->surveyls_title;
		$data['opPosibles']=$opPosibles;
		$data['opAsignados']=$opAsignados;
		$data['opAsignados']=$opAsignados;
		$data['opIdAsignados']=json_encode($opIdAsignados);
		
		return view('admin\operadores' , ['data' => $data]);	
		
	}
	
	public function save(Request $request,$sid)
	{

		

		$idOperadores=json_decode($request->input('operadoresID'));

		var_dump($idOperadores);

		//Borramos todos
		DB::table('survey_operators')->where('idSurvey',$sid)->delete();

		$opAsignados = DB::table('usuarios_operadores')
					->whereIn('id',$idOperadores)
					->orderBy('order','asc')
					->get();
		
		foreach ($opAsignados  as $operador ) {
			
			DB::table('survey_operators')->insert([
				'idSurvey'=>$sid,
				'idOperator'=>$operador->id
				]);
		}

		return Redirect::to('survey/'.$sid.'/operadores')->with('status', '¡Operadores asignados guardados correctamente!');

	}

}
