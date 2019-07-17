<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'API Running!'], 200);
});
Route::get('/web/auth/login', 'AdministradorController@showLogin')->name('login');
Route::post('/web/auth/login_post', 'AdministradorController@clienLogin')->name('login_post');
/* Custom urls web */
Route::resource('administrador', 'AdministradorController')->middleware('auth');

/* For datatables */
Route::get('list-ingredientes', 'AdministradorController@dataIngredientes')->name('datatable.ingredientes');
Route::get('list-platillos', 'AdministradorController@dataPlatillos')->name('datatable.platillos');
Route::get('list-clasificaciones', 'AdministradorController@dataClasificaciones')->name('datatable.clasificaciones');