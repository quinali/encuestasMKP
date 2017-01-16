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
		$this ->middleware('check.admin');
		
	}
	
	
	public function index(Request $request)
	{
		//Si llega parametro de filtro se utiliza en la construccion de la consulta
		$filterName = $request->input('filterName');
		
		if(isset($filterName))
		{
			$surveys = DB::table('surveys')
					->join('surveys_languagesettings', 'surveys.sid', '=', 'surveys_languagesettings.surveyls_survey_id')
					->where('surveys_languagesettings.surveyls_title','LIKE','%'.$filterName.'%')
					->orderBy('surveys_languagesettings.surveyls_title', 'asc')
					->paginate(env('NUMRESULTAPERPAG', '20'));
		}else{
			$surveys = DB::table('surveys')
					->join('surveys_languagesettings', 'surveys.sid', '=', 'surveys_languagesettings.surveyls_survey_id')
					->orderBy('surveys_languagesettings.surveyls_title', 'asc')
					->paginate(env('NUMRESULTAPERPAG', '20'));
		}
					
					
		$surveys->setPath('admin');
		
		return view('admin/console' , ['surveys' => $surveys,'filterName'=>$filterName]);	
		
	}
	
}
