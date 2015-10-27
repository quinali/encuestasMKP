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

class DispatchController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
		$this ->middleware('check.admin');
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
		
		
		return view('admin\dispatch',['data' => $data]);	
		
	}

}
