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

		$plugin_settings = DB::table('plugin_settings')
									->where('key',$sid)
									->first();

		//Validamos si ya esta encuesta ya tenia registro 							
		if($plugin_settings == null){
			DB::table('plugin_settings')
				->insert([
					['plugin_id'=>8,'model'=>'mkp_recall','model_id'=>1, 'key'=>$sid]
					]);
		}	
		$isConfirmation = DB::table('plugin_settings')
						-> where('key',$sid)
						-> select ('isConfirmation')
						-> first();

		//Primero valida si existe la tabla de survey y la de tokens
		$sql = 'select count(1) as existe'.
						' from information_schema.tables'.
						' where TABLE_NAME in ("survey_'.$sid.'","tokens_'.$sid.'")'.
						' and table_schema =database()';

		$check = DB::select($sql)[0]->existe;

		if($check <>'2'){
			if($check =='0')
				return Redirect()->route('admin')->with('status', 'La encuesta en cuestión aun no ha sido creada.');
			else if ($check =='1')
				return Redirect()->route('admin')->with('status', 'Lista de clientes aún no ha sido cargada.');
		}

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
		
		//Dependiendo de si es o no confirmacion hacemos una u otra consulta			
		if($isConfirmation->isConfirmation == 0){
			
			//Encuestas de primera ronda			
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

		}else{

			//Encuestas de confirmacion
			$contactColumn = $sid.'X'.SettingsController::getAnwswerGroup($sid).'X'.SettingsController::getHaConstactadoAnswer($sid);		

			$sqlLlamadasEmitidasRecuperables="select count(1) as num from tokens_".$sid." where token in".
							" ( ".
	  						"	select maxTable.token ".
	  						"	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
	  						"	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
	  						"	where `".$contactColumn."`='N' ".
							" ) and tokens_".$sid.".completed<>'N'";
				
			$llamadasEmitidasRecuperables = DB::select($sqlLlamadasEmitidasRecuperables);						

			$sqlLlamadasEmitidasNoRecuperables="select count(1) as num from tokens_".$sid." where token in".
							" ( ".
	  						"	select maxTable.token ".
	  						"	from ( select token,max(id) as maxid from survey_".$sid." group by token) as maxTable ".
	  						"	inner join survey_".$sid." as sv on maxTable.token=sv.token and maxTable.maxId = sv.id ".
	  						"	where `".$contactColumn."`='Y' ".
							" ) and tokens_".$sid.".completed<>'N'";

			$llamadasEmitidasNORecuperables = DB::select($sqlLlamadasEmitidasNoRecuperables);

		}



		$sqlOperadores ="	SELECT uOp.name as name, ".
						"	(select count(1) from tokens_".$sid." tk2 where tk2.attribute_1=tok1.operador and completed='N' and usesleft=1) as ptesNuncaRealizadas, ".
						"	(select count(1) from tokens_".$sid." tk2 where tk2.attribute_1=tok1.operador and completed='N' and usesleft<>1) as ptesRecuperadas, ".
						"   (select count(1) from tokens_".$sid." tk2 where tk2.attribute_1=tok1.operador and completed<> 'N' ) as ejecutadas ".
						"	FROM  ".
						"	(select distinct(attribute_1) as operador from tokens_".$sid." where attribute_1 is not null group by attribute_1) as tok1  ".
						"	left join usuarios_operadores uOp on tok1.operador=uOp.id ".
						"	order by uOp.`order` ";

		//var_dump($sqlOperadores);		

		$llamadasPorOperadores = DB::select($sqlOperadores);					

		$data = array();
		$data['survey_title']=$surveys_languagesettings->surveyls_title;
		$data['sid']=$sid;
		$data['isConfirmation']=$isConfirmation->isConfirmation;

		$data['LlamPdtesNoRealizadas']=$llamadasPdtesNoRealizadas;
		$data['LlamPdtesRecuperadas']=$llamadasPdtesRecuperadas;

		$data['LlamEmitidasRecuperables']=$llamadasEmitidasRecuperables[0]->num;			
		$data['LlamEmitidasNoRecuperables']=$llamadasEmitidasNORecuperables[0]->num;	

		$data['llamadasPorOperadores']=$llamadasPorOperadores;
		
		return view('admin/survey' , ['data' => $data]);	
		
	}


}
