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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


//Agregamos nuestra ruta al controller 
//Route::resource('platillos', 'PlatilloController');
//Agregamos nuestra ruta al controller 
//Route::resource('ingredientes', 'IngredienteController');
Route::group(['prefix' => 'auth'], function () {

    // Whitout autentication
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group(['middleware' => 'auth:api'], function() {
        // Whith autentication
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});