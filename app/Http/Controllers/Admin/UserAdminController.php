<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class UserAdminController extends Controller
{
   public function __construct()
	{
		$this ->middleware('auth');
		$this ->middleware('check.admin');
	}
	
	
	public function index()
	{
		$users = DB::table('usuarios_operadores')->orderBy('name', 'asc')->paginate(env('NUMRESULTAPERPAG', '20'));
		$users->setPath('usuarios');

        return view('admin/users', ['users' => $users]);	
		
	}
	
}
