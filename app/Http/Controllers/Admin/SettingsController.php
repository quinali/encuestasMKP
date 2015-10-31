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
		$this ->middleware('check.admin');
	}
	
	
	public function index($sid)
	{
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
		
		return view('admin/settings_edit',['data' => $data]);	
	}
	


	public function calculateUrl(Request $request,$sid){

		return ($request->root().'/llamadas/'.$sid);
	}


	public function calculateUrlTitle($sid){

		$urlTitle="Listado de clientes";
		return ($urlTitle);
	}


	public function calculatePlugginSetting($sid){

		$gid=$this->getAnwswerGroup($sid);

		$qid1 = $this->getHaConstactadoAnswer($sid);
		$qid2 = $this->getRellamadaAnswer($sid);
		$qid3 = $this->getMotivoRellamarAnswer($sid);

		$plugin_settings=$qid3.",X".$gid."X".$qid1.",X".$gid."X".$qid2.",X".$gid."X".$qid3;

		return ($plugin_settings);
	}


	public function updateUrl(Request $request,$sid){

			log::debug('Updating URL of '.$sid.' with '.$request->input('url'));

			DB::table('surveys_languagesettings')
				->where('surveyls_survey_id',$sid)
				->update(['surveyls_url'=>$request->input('url')]);

			return Redirect::to('survey/'.$sid.'/settings')->with('status', 'URL actualizada correctamente');
}



	public function updateUrlTitle(Request $request,$sid){

			log::debug('Updating URL Title of '.$sid.' with '.$request->input('title'));

			DB::table('surveys_languagesettings')
				->where('surveyls_survey_id',$sid)
				->update(['surveyls_urldescription'=>$request->input('title')]);

			return Redirect::to('survey/'.$sid.'/settings')->with('status', 'Titulo de la URL actualizado correctamente');	
	}


	public function updatePluginSetting(Request $request,$sid){

			log::debug('Updating plugin_settings of '.$sid.' with '.$request->input('plugginSettings'));

			DB::table('plugin_settings')
				->where('key',$sid)
				->update(['value'=>$request->input('plugginSettings')]);

			return $this->index($sid);
	}


	public static function getAnwswerGroup($sid){

		return 	$gid=DB::table('groups')
			->select('gid')
			->where('sid',$sid)
			->where('group_name','G1')
			->first()
			->gid;


	}


	public static function getHaConstactadoAnswer($sid){

		$sqlQid1="select qid from questions q where sid=:sid and title='G1P1' and locate('¿Ha contactado con el cliente?',question)<>0";
		
		$qid1 = DB::select( DB::raw($sqlQid1), array('sid' => $sid))[0]->qid;

		return $qid1;

	}

	public static function getRellamadaAnswer($sid){

		$sqlQid2=" select qid from questions q where sid=:sid and title='G1P2' ".
				  " and (locate('En caso de no haber contactado con el cliente indique la causa',question)<>0 OR locate('En caso de no haber contactado indique la causa',question)<>0)";

		$qid2 = DB::select( DB::raw($sqlQid2), array('sid' => $sid))[0]->qid;

		return $qid2;

	}


	public static function getMotivoRellamarAnswer($sid){

		$sqlQid3= " select qid from questions q where sid=:sid".
				  " and title='G1P3' ".
				  " and (locate('Indique la causa por la que hay que volver a llamar al cliente',question)<>0 ".
				  "		OR locate('Indique la causa por la que sea necesario volver a llamar al cliente.',question)<>0)";
				
		$qid3 = DB::select( DB::raw($sqlQid3), array('sid' => $sid))[0]->qid;

		return $qid3;
	}

	public static function getObservacionesAnswerColumn($sid){
		
		$sqlQid= " select gid,qid from questions q where sid=:sid and locate('indique las observaciones',question)<>0";
				
		$gid = DB::select( DB::raw($sqlQid), array('sid' => $sid))[0]->gid;
		$qid = DB::select( DB::raw($sqlQid), array('sid' => $sid))[0]->qid;

		return $sid."X".$gid."X".$qid;
	}

}
