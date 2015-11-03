<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Log;
use Auth;
use App\Http\Controllers\Auth\AuthController;
use App\User;
use Redirect;

class UserController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
		$this ->middleware('check.admin');
	}
	
	
	public function index($id)
	{
		$user= User::find($id);
		
		return view('admin/user_edit',['user' => $user]);	
		
	}
	
	
	public function update(Request $request)
	{
		$input = $request->all();

		$password=$input['password'];
		$password_confirmation=$input['password_confirmation'];

		if($password <> $password_confirmation){
			return Redirect()->route('user.edit.get', [$input['id']])->with('status', 'Las contraseñas no coindiden: ');
		}

		//Actualizamos todo menos password
		DB::table('usuarios_operadores')
            ->where('id', $input['id'])
            ->update(['name' => $input['name'],'email' => $input['email'] ]);
		
		//Actualizamos password
        if(strlen ($password)<5)
        	return Redirect()->route('user.edit.get', [$input['id']])->with('status', 'Las contraseñas debe tener 5 o más caracteres: ');
        else
        	DB::table('usuarios_operadores')
        		->where('id', $input['id'])
        		->update(['password' => bcrypt($password) ]);

		return Redirect::to('admin/usuarios')->with('status', 'Usuario actualizado');
	}
}
