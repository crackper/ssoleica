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

//dataform routing
Burp::post(null, 'process=1', array('as'=>'save', function() {
    BurpEvent::queue('dataform.save');
}));

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

Route::post('pais/workspace',['as' =>'pais.workspace','uses' =>'PaisController@workspace']);
Route::resource('pais','PaisController');

Route::group(array('middleware' => 'auth'), function(){
    Route::get('repositorio', 'FilemanagerLaravelController@getRepository');
    Route::controller('filemanager', 'FilemanagerLaravelController');
});


