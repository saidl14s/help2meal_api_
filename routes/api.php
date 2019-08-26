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
    /* FOR SECURITY */
    Route::post('checkToken', 'AuthController@checkToken'); 
    /*  */
  
    Route::group(['middleware' => 'auth:api'], function() {
        // Whith autentication
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('update', 'AuthController@update');
        Route::resource('platillos', 'PlatilloController');
        Route::post('platillos-last', 'PlatilloController@lastRecipes'); // ultimos platillos cocinados por el usuario
        Route::post('platillos-ai', 'PlatilloController@ai'); // busqueda de recetas para el usuario
        Route::post('platillos-history', 'PlatilloController@history'); // recetas cocinadas por el usuario
        Route::post('get-enfermedades', 'ClasificacionController@getEnfermedades');
        Route::post('get-gustos', 'ClasificacionController@getGustos');
        Route::get('get-ingredients-recipe/{id}', 'PlatilloController@getIngredientRecipe');
        Route::get('clasificaciones-ingredientes', 'ClasificacionController@showIngredientes');

        Route::resource('ingredientes', 'IngredienteController');
        Route::get('ingredientes-get', 'IngredienteController@indexInventary');
        Route::get('enfermedades-get', 'ClasificacionController@indexPreferencesUser');
        Route::get('gustos-get', 'ClasificacionController@indexGustosUser');
        Route::post('user-ingredientes-save', 'IngredienteController@saveUser');
        Route::post('user-gustos-save', 'ClasificacionController@saveGustosUser'); //pending
        Route::post('user-enfermedades-save', 'ClasificacionController@saveEnfermedadesUser'); //pending
        Route::resource('clasificaciones', 'ClasificacionController');
        Route::post('ingredientes-user-update', 'IngredienteController@updateUser');
        Route::get('new-recipes', 'PlatilloController@newsRecipes');
        // custom functions
    });
});