<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login',    'AuthController@login');
    Route::post('logout',   'AuthController@logout');
    Route::post('refresh',  'AuthController@refresh');
    Route::post('profile',  'AuthController@profile');
});

Route::middleware('auth:api')->group(function () {
    Route::get('sites',  'SiteController@index');
    Route::post('sites', 'SiteController@store');
    // Route::resource('sites', 'SiteController');

    Route::get('customers', 'CustomersController@all');
    Route::get('customers/{id}', 'CustomersController@get');
    Route::post('customers/new', 'CustomersController@new');
});
