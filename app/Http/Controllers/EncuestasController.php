<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;

class EncuestasController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
	}
	
	
	public function index()
	{
		$sqlEncuestas ="SELECT srv.sid,srvLang.surveyls_title ".
			" FROM surveys srv ".
			" LEFT JOIN surveys_languagesettings srvLang ON srv.sid = srvLang.surveyls_survey_id ".
			" WHERE  1=1 ".
			" AND srv.active='Y' ".
			" AND (srv.expires is NULL OR srv.expires > now()) ORDER BY surveyls_title  ";
		
		$encuestas = DB::select($sqlEncuestas);
		$encuestasTotales = array();
		
		foreach ($encuestas as $encuesta){
			
			$sqlTotales ="select ".
				" ( select count(1) from tokens_".$encuesta->sid." tok where tok.completed='N' and tok.attribute_1=:operatorName) as pdtes,".
				" ( select count(1) from tokens_".$encuesta->sid." tok WHERE tok.attribute_1=:operatorName) as tot;";			
			
			$encuestaTotales = DB::select('select '.
				' ( select count(1) from tokens_'.$encuesta->sid.' tok where tok.completed="N" and tok.attribute_1= ?) as pdtes,'.
				' ( select count(1) from tokens_'.$encuesta->sid.' tok WHERE tok.attribute_1=?) as tot', 
				[Auth::user()->name, Auth::user()->name]);
						
			$encuesta = (array)$encuesta;
			$encuesta['pdtes'] = $encuestaTotales[0]->pdtes;
			$encuesta['tot'] = $encuestaTotales[0]->tot;
			$encuesta = (object)$encuesta;
			
			//Solo mete los que tengan valores <>0
			if($encuestaTotales[0]->pdtes + $encuestaTotales[0]->tot > 0){
					array_push($encuestasTotales,$encuesta);
			}
			
		}
		
		return view('encuestas',   ['encuestas' => $encuestasTotales]);	
		
	}
	
}
