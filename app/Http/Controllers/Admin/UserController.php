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

class UserController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
	}
	
	
	public function index($id)
	{
		log::debug("Entrando en la edicion del usuario ".$id);
		
		$user= User::find($id);
		
		return view('admin\user_edit',['user' => $user]);	
		
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
