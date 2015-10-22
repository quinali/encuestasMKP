<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;

class OperadoresController extends Controller
{
   public function __construct()
	{
		//$this ->middleware('auth');
	}
	
	
	public function index($sid)
	{
		log::debug("Entrando en zona de administracion de operadores de la encuesta ".$sid);
		
		$surveys_languagesettings = DB::table('surveys_languagesettings')
					->where('surveyls_survey_id',$sid)
					->first();

		$operadores = DB::table('usuarios_operadores')
					->get();
		

		$opAsignados = DB::table('survey_operators')
					->where('idSurvey',$sid)
					->get();
		
		$data = array();

		$data['sid']=$sid;
		$data['survey_title']=$surveys_languagesettings->surveyls_title;
		$data['operadores']=$operadores;
		$data['opAsignados']=$opAsignados;
		
		return view('admin\operadores' , ['data' => $data]);	
		
	}
	
}
