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
Route::get('/encuestas', ['as' => 'encuestas','uses' => 'EncuestasController@index']);

Route::get('llamadas/{sid}',  						['uses' => 'LlamadasController@index']);
Route::get('rellamar/{sid}/{tid}',  				['uses' => 'LlamadasController@rellamar']);



//Zona de administracion
Route::get('admin/',  								['as' => 'admin','uses' => 'Admin\AdminController@index']);
Route::get('admin/usuarios',						['uses' => 'Admin\UserAdminController@index']);

Route::get ('admin/user/edit/{id}', 				['as' => 'user.edit.get',	'uses' => 'Admin\UserController@index']);
Route::post('admin/user/edit',						['as' => 'user.edit',	'uses' => 'Admin\UserController@update']);


Route::get('survey/{sid}',  						['uses' => 'Admin\SurveyController@index']);
Route::get('survey/{sid}/operadores',  				['uses' => 'Admin\OperadoresController@index']);
Route::post('survey/{sid}/operadores',  			['as' 	=> 'admin\operadores','uses' => 'Admin\OperadoresController@save']);
Route::get('survey/{sid}/settings',  				['uses' => 'Admin\SettingsController@index']);

Route::get('survey/{sid}/dispatch', 				['uses' => 'Admin\DispatchController@index']);
Route::post('survey/{sid}/dispatch', 				['as'=>'admin.reassign','uses' => 'Admin\DispatchController@reassign']);
Route::post('survey/{sid}/deallocate', 				['as'=>'admin.deallocate','uses' => 'Admin\DispatchController@deallocate']);
Route::post('survey/{sid}/recover', 				['as'=>'admin.recover','uses' => 'Admin\DispatchController@recover']);

Route::get('survey/{sid}/settings/url', 			['uses' => 'Admin\SettingsController@calculateUrl']);
Route::get('survey/{sid}/settings/urlTitle',		['uses' => 'Admin\SettingsController@calculateUrlTitle']);
Route::get('survey/{sid}/settings/pluginSetting', 	['uses' => 'Admin\SettingsController@calculatePlugginSetting']);

Route::post('survey/{sid}/settings/pluginSetting', 	['as'=>'url.updateSetting','uses' => 'Admin\SettingsController@updatePluginSetting']);



// Authentication routes...
Route::get('auth/login', 							 'Auth\AuthController@getLogin');
Route::post('auth/login', 							['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', 							['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 						  'Auth\AuthController@getRegister');
Route::post('auth/register',						 ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);


Route::controllers([
	'auth'		 => 'Auth\AuthController',
	'password'	 => 'Auth\PasswordController',
]);