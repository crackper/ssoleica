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
    Route::controller('enums','EnumTablesController');
    Route::controller('permisos','PermisosController');
    Route::controller('roles','RolesController');
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('/contrato/ampliacion-pendiente','ContratoController@getAmpliacionPendiente');
    Route::get('/contrato/aprobar-ampliar-contrato/{id}','ContratoController@getAprobarAmpliarContrato');
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

    //Route::get('trabajador/create',['middleware' => ['permission:create_trabajador'],'uses'=> 'TrabajadorController@getIndex']);

    Entrust::routeNeedsPermission('trabajador*', 'view_trabajador',Redirect::to('/home'));
    Entrust::routeNeedsPermission('trabajador/create', 'create_trabajador',Redirect::to('/trabajador'));
    Entrust::routeNeedsPermission('trabajador/edit*', 'edit_trabajador',Redirect::to('/trabajador'));
    Entrust::routeNeedsPermission('trabajador/delete*', 'delete_trabajador',Redirect::to('/trabajador'));

    Route::controller('trabajador','TrabajadorController');

    Route::controller('incidente','IncidenteController');

    Route::get('trabajador/{id}/delete',['as'=>'index.delete','uses'=>'TrabajadorController@delete']);
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

Route::filter('trabajador/anyCreate', function()
{
    // check the current user
    if (!Entrust::can('create_trabajador')) {
        return Redirect::to('trabajador');
    }
});


