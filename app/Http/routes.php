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

Route::group(['middleware' => ['entrust', 'auth'], 'roles' => 'admin'], function(){
    Route::get('/auth/register', 'Auth\AuthController@register');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
});
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);

Route::group(['middleware' => ['entrust', 'auth'], 'roles' => 'admin'], function(){
    Route::controller('user','UserController');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::get('/', 'WelcomeController@index');


Route::get('home', 'HomeController@index');
Route::get('help/{seccion?}', 'HomeController@help');
Route::get('grid','HomeController@grid');
Route::get('form','HomeController@form');
Route::get('profile', 'UserController@profile');

Route::group(['middleware' => ['entrust', 'auth'], 'roles' => array('admin','apr')], function(){
    Route::controller('operacion','OperacionController');
    Route::controller('contrato','ContratoController');
    Route::controller('horasHombre','HorasHombreController');
    Route::controller('estadisticas','EstadisticaSegController');
    Route::get('trabajador/{id}/delete',['as'=>'index.delete','uses'=>'TrabajadorController@delete']);
    Route::controller('trabajador','TrabajadorController');
    Route::controller('incidente','IncidenteController');
});

Route::group(['middleware' => ['entrust', 'auth'], 'roles' => array('admin','apr','joperaciones','gerente')], function(){
    Route::get('repository', 'FilemanagerLaravelController@getRepository');
    Route::get('connectors', 'FilemanagerLaravelController@getConnectors');
    Route::post('connectors', 'FilemanagerLaravelController@postConnectors');
    Route::controller('alertas','AlertasController');
});


Route::post('pais/workspace',['as' =>'pais.workspace','uses' =>'PaisController@workspace']);
Route::resource('pais','PaisController');



//filtro para el ajax
Route::filter('csrf', function() {
    $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
    if (Session::token() != $token)
        throw new Illuminate\Session\TokenMismatchException;
});



