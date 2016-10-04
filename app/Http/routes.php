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

// Home index page
Route::get('/', function () {
    return view('index');
});

Route::auth();

// Provide controller methods with object instead of ID
Route::model('terms', 'Term');

Route::bind('terms', function($value, $route) {
	return App\Term::whereId($value)->first();
});

//Model routes
Route::resource('terms', 'TermController');

// Excel
Route::get('uploadexcel', ['middleware' => 'auth', 'uses' => 'ExcelController@upload']);
Route::post('postexcel', ['middleware' => 'auth', 'uses' => 'ExcelController@postexcel']);
Route::get('downloadexcel', ['middleware' => 'auth', 'uses' => 'ExcelController@download']);
