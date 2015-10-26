<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;

class AdminController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
	}
	
	
	public function index()
	{
		log::debug("Entrando en zona de administracion");
		
		//$sqlEncuestas ="select srv.sid,srvLang.surveyls_title from surveys srv left join surveys_languagesettings srvLang on srv.sid = srvLang.surveyls_survey_id";

		$surveys = DB::table('surveys')
					->join('surveys_languagesettings', 'surveys.sid', '=', 'surveys_languagesettings.surveyls_survey_id')
					->orderBy('surveys_languagesettings.surveyls_title', 'asc')
					->paginate(env('NUMRESULTAPERPAG', '20'));

		$surveys->setPath('admin');

     	
		return view('admin\console' , ['surveys' => $surveys]);	
		
	}
	
}
