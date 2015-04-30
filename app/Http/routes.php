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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('grid','HomeController@grid');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//Route::get('trabajador','TrabajadorController@index');
Route::get('trabajador/{id}/delete',['as'=>'index.delete','uses'=>'TrabajadorController@delete']);
Route::resource('trabajador','TrabajadorController');
