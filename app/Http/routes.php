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