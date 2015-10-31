<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\SettingsController;
use DB;
use Log;
use Auth;

class SurveyController extends Controller
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

		$llamadasPdtesNoRealizadas = DB::table('tokens_'.$sid)
					->where('completed','N')
					->where('usesleft','1')
					->count();
		
		$llamadasPdtesRecuperadas = DB::table('tokens_'.$sid)
					->where('completed','N')
					->where('usesleft','<>','1')
					->count();
		
		$rellamadaColumn = $sid.'X'.SettingsController::getAnwswerGroup($sid).'X'.SettingsController::getRellamadaAnswer($sid);			

		$sqlLlamadasEmitidasRecuperables="select count(1) as num from tokens_".$sid." where token in".
						" ( ".
  						"	select maxTable.token ".
  						"	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
  						"	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
  						"	where `".$rellamadaColumn."`='A1' ".
						" ) and tokens_".$sid.".completed<>'N'";
			
		$llamadasEmitidasRecuperables = DB::select($sqlLlamadasEmitidasRecuperables);						

		$sqlLlamadasEmitidasNoRecuperables="select count(1) as num from tokens_".$sid." where token in".
						" ( ".
  						"	select maxTable.token ".
  						"	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
  						"	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
  						"	where `".$rellamadaColumn."`='A2' ".
						" ) and tokens_".$sid.".completed<>'N'";

		$llamadasEmitidasNORecuperables = DB::select($sqlLlamadasEmitidasNoRecuperables);

		$sqlOperadores ="	SELECT uOp.name as name, ".
						"	(select count(1) from tokens_".$sid." tk2 where tk2.attribute_1=tok1.operador and completed='N' and usesleft=1) as ptesNuncaRealizadas, ".
						"	(select count(1) from tokens_".$sid." tk2 where tk2.attribute_1=tok1.operador and completed='N' and usesleft<>1) as ptesRecuperadas, ".
						"	( ".
						"	  select count(1) from tokens_".$sid." where tokens_".$sid.".token in ".
						"	(select maxTable.token ".
						"	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
						"	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
						"	where `".$rellamadaColumn."`='A1' ".
						"	) and tokens_".$sid.".completed<>'N' ".
						"	  and tokens_".$sid.".attribute_1=tok1.operador	".
						"	)as ejecutadasRecuperables, ".
						"	( ".
						"	  select count(1) from tokens_".$sid." where tokens_".$sid.".token in ".
						"	(select maxTable.token ".
						"	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
						"	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
						"	where `".$rellamadaColumn."`='A2' ".
						"	) and tokens_".$sid.".completed<>'N' ".
						"	  and tokens_".$sid.".attribute_1=tok1.operador	".
						"	)as ejecutadasNORecuperables ".
						"	FROM  ".
						"	(select distinct(attribute_1) as operador from tokens_".$sid." where attribute_1 is not null group by attribute_1) as tok1  ".
						"	left join usuarios_operadores uOp on tok1.operador=uOp.id ".
						"	order by uOp.`order` ";

		$llamadasPorOperadores = DB::select($sqlOperadores);					

		$data = array();
		$data['survey_title']=$surveys_languagesettings->surveyls_title;
		$data['sid']=$sid;
		$data['LlamPdtesNoRealizadas']=$llamadasPdtesNoRealizadas;
		$data['LlamPdtesRecuperadas']=$llamadasPdtesRecuperadas;

		$data['LlamEmitidasRecuperables']=$llamadasEmitidasRecuperables[0]->num;			
		$data['LlamEmitidasNoRecuperables']=$llamadasEmitidasNORecuperables[0]->num;	

		$data['llamadasPorOperadores']=$llamadasPorOperadores;
		
		return view('admin/survey' , ['data' => $data]);	
		
	}


}
