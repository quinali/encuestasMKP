<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;

class SurveyController extends Controller
{
   public function __construct()
	{
		//$this ->middleware('auth');
	}
	
	
	public function index($sid)
	{
		log::debug("Entrando en zona de administracion de encuesta ".$sid);
		
		
		$surveys_languagesettings = DB::table('surveys_languagesettings')
					->where('surveyls_survey_id',$sid)
					->first();


		$llamadasPdtes = DB::table('tokens_'.$sid)
					->where('completed','N')
					->count();
					
		$llamadasEmitidas = DB::table('tokens_'.$sid)
					->where('completed','<>','N')
					->count();
		
		$llamadasTotales = DB::table('tokens_'.$sid)
					->where('completed','N')
					->count();



		$OpTotal = DB::table('survey_operators')
					->where('idSurvey',$sid)
					->count();			

		//DB::enableQueryLog();			
		
		$OpConLlamada=DB::table('tokens_'.$sid)
					->whereNotNull('attribute_1')
					->groupBy('attribute_1')
					->select('attribute_1')
					->get();	

		
		$sqlOperadores ="SELECT CONVERT(SUBSTRING(operador,4),UNSIGNED INTEGER)+ (IF(STRCMP(SUBSTRING(operador,1,3),'sev'),1,100))as orden,".
						"operador, ".
						"(select count(1) from tokens_".$sid." tk2 where tk2.attribute_1=tok1.operador and completed='N') as ptes, ".
						"(select count(1) from tokens_".$sid." tk3 where tk3.attribute_1=tok1.operador and completed<>'N') as ejecutadas ".
						"FROM ".
						"(select distinct(attribute_1) as operador from tokens_".$sid."  group by attribute_1) as tok1 order by orden";

		$llamadasPorOperadores = DB::select($sqlOperadores);					
		



		$data = array();
		$data['survey_title']=$surveys_languagesettings->surveyls_title;
		$data['sid']=$sid;
		$data['LlamPdtes']=$llamadasPdtes;
		$data['LlamHechas']=$llamadasEmitidas;			
		$data['LlamTotal']=$llamadasTotales;	

		$data['OpConLlamada']=sizeof($OpConLlamada);			
		$data['OpTotal']=$OpTotal;	

		$data['llamadasPorOperadores']=$llamadasPorOperadores;



		
		return view('admin\survey' , ['data' => $data]);	
		
	}
	
}
