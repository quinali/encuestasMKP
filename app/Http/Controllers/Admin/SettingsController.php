<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;
use App\User;
use Redirect;

class SettingsController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
	}
	
	
	public function index($sid)
	{
		log::debug("Entrando en la edicion de parametros de la encuestas ".$sid);
		
		
		$surveys_languagesettings = DB::table('surveys_languagesettings')
									->where('surveyls_survey_id',$sid)
									->first();
		
		$plugin_settings = DB::table('plugin_settings')
									->where('key',$sid)
									->first();
		
		$data = array();
		
		$data['sid']=$sid;
		$data['survey_title']=$surveys_languagesettings->surveyls_title;
		$data['surveyls_url']=$surveys_languagesettings->surveyls_url;
		$data['surveyls_urldescription']=$surveys_languagesettings->surveyls_urldescription;
		$data['pluggins_settings']=$plugin_settings->value;
		
		
		return view('admin\settings_edit',['data' => $data]);	
		
	}
	
	
	
	public function calculateUrl(Request $request,$sid){

		log::debug("----->calculateUrl()");

		return ($request->root().'/llamadas/'.$sid);

	}

	public function calculateUrlTitle($sid){

		$urlTitle="Listado de clientes";

		return ($urlTitle);


	}

	public function calculatePlugginSetting($sid){


		DB::connection()->enableQueryLog();

		$gid=DB::table('groups')
			->select('gid')
			->where('sid',$sid)
			->where('group_name','G1')
			->first()
			->gid;



		$sqlQid1="select qid from questions q where sid=:sid and title='G1P1' and locate('¿Ha contactado con el cliente?',question)<>0";
		$qid1 = DB::select( DB::raw($sqlQid1), array('sid' => $sid))[0]->qid;


		$sqlQid2=" select qid from questions q where sid=:sid and title='G1P2' ".
				  " and (locate('En caso de no haber contactado con el cliente indique la causa',question)<>0 OR locate('En caso de no haber contactado indique la causa',question)<>0)";

		$qid2 = DB::select( DB::raw($sqlQid2), array('sid' => $sid))[0]->qid;
	

		$sqlQid3= " select qid from questions q where sid=:sid".
				  " and title='G1P3' ".
				  " and (locate('Indique la causa por la que hay que volver a llamar al cliente',question)<>0 ".
				  "		OR locate('Indique la causa por la que sea necesario volver a llamar al cliente.',question)<>0)";
				
		$qid3 = DB::select( DB::raw($sqlQid3), array('sid' => $sid))[0]->qid;

		$plugin_settings=$qid3.",X".$gid."X".$qid1.",X".$gid."X".$qid2.",X".$gid."X".$qid3;

		return ($plugin_settings);

	}



	public function updateUrl(Request $request,$sid){

			log::debug('Updating URL of '.$sid.' with '.$request->input('url'));

			DB::table('surveys_languagesettings')
				->where('surveyls_survey_id',$sid)
				->update(['surveyls_url'=>$request->input('url')]);

			return $this->index($sid)->with('status', 'URL actualizada correctamente!');





	}



	public function updateUrlTitle(Request $request,$sid){

			log::debug('Updating URL Title of '.$sid.' with '.$request->input('title'));

			DB::table('surveys_languagesettings')
				->where('surveyls_survey_id',$sid)
				->update(['surveyls_urldescription'=>$request->input('title')]);

			return $this->index($sid);
	}


	public function updatePluginSetting(Request $request,$sid){

			log::debug('Updating plugin_settings of '.$sid.' with '.$request->input('plugginSettings'));

			DB::table('plugin_settings')
				->where('key',$sid)
				->update(['value'=>$request->input('plugginSettings')]);

			return $this->index($sid);
	}

}
