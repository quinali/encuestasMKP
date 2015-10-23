<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () { return view('auth/login'); });

/*Zona de operadores*/
Route::get('/encuestas', 'EncuestasController@index');

Route::get('llamadas/{sid}',  		['uses' => 'LlamadasController@index']);
Route::get('rellamar/{sid}/{tid}',  ['uses' => 'LlamadasController@rellamar']);



//Zona de administracion
Route::get('admin/',  				['uses' => 'Admin\AdminController@index']);
Route::get('admin/usuarios',		['uses' => 'Admin\UserAdminController@index']);

Route::get ('admin/user/edit/{id}', ['as' => 'user.edit',	'uses' => 'Admin\UserController@index']);
Route::post('admin/user/edit',		['as' => 'user.edit',	'uses' => 'Admin\UserController@update']);


Route::get('survey/{sid}',  			['uses' => 'Admin\SurveyController@index']);
Route::get('survey/{sid}/operadores',  	['uses' => 'Admin\OperadoresController@index']);
Route::post('survey/{sid}/operadores',  ['as' => 'admin\operadores','uses' => 'Admin\OperadoresController@save']);
Route::get('survey/{sid}/settings',  	['uses' => 'Admin\SettingController@index']);


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);


Route::controllers([
	'auth'		 => 'Auth\AuthController',
	'password'	 => 'Auth\PasswordController',
]);