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

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('grid','HomeController@grid');
Route::get('form','HomeController@form');

//Route::get('trabajador','TrabajadorController@index');
Route::get('trabajador/{id}/delete',['as'=>'index.delete','uses'=>'TrabajadorController@delete']);
Route::controller('trabajador','TrabajadorController');

Route::controller('operacion','OperacionController');
Route::controller('contrato','ContratoController');
Route::controller('horasHombre','HorasHombreController');

Route::post('pais/workspace',['as' =>'pais.workspace','uses' =>'PaisController@workspace']);
Route::resource('pais','PaisController');

//Route::group(array('middleware' => 'auth'), function(){
    Route::get('repository', 'FilemanagerLaravelController@getRepository');
    Route::get('connectors', 'FilemanagerLaravelController@getConnectors');
    Route::post('connectors', 'FilemanagerLaravelController@postConnectors');
    //Route::controller('filemanager', 'FilemanagerLaravelController');
//});

//filtro para el ajax
Route::filter('csrf', function() {
    $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
    if (Session::token() != $token)
        throw new Illuminate\Session\TokenMismatchException;
});


