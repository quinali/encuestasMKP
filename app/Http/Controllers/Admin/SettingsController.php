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
		//$this ->middleware('auth');
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
	
	
	public function update(Request $request)
	{
		$input = $request->all();
		
		print_r($input);
		
		DB::table('usuarios_operadores')
            ->where('id', $input['id'])
            ->update(['name' => $input['name'],'email' => $input['email'] ]);
		
		return Redirect::to('admin/usuarios')->with('message', 'Usuario actualizado');
		
        
		
	}
}
