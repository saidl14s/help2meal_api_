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
Route::get('privacy', function () {
    return view('privacy');
});

Route::get('install-play-store', function () {
    return redirect('https://play.google.com/store/apps/details?id=com.itcg.help2meal');
});

Route::get('/', function () {
    try {
        DB::connection()->getPdo();
        if(DB::connection()->getDatabaseName()){
            return response()->json([
                'message' => 'API Running Succesfully!'], 200);
        }else{
            return response()->json([
                'message' => 'Could not find the database. Please check your configuration!'], 503);
        }
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Could not open connection to database server.  Please check your configuration!'], 503);
    }
});
Route::get('/web/auth/login', 'AdministradorController@showLogin')->name('login');
Route::post('/web/auth/login_post', 'AdministradorController@clienLogin')->name('login_post');
/* Custom urls web */
Route::resource('administrador', 'AdministradorController')->middleware('auth');
Route::get('create-recipe', 'AdministradorController@createRecipe');
Route::post('platillo/store','PlatilloController@store')->name('admin-platillo.store');
Route::get('create-classification', 'AdministradorController@createClassification');
Route::get('create-ingredient', 'AdministradorController@createIngredient');
Route::post('store-ingredient-admin','AdministradorController@storeIngredient')->name('admin-ingredient.store');

Route::post('clasificacion/store','ClasificacionController@store')->name('admin-clasificacion.store');

/* For datatables */
Route::get('list-ingredientes', 'AdministradorController@dataIngredientes')->name('datatable.ingredientes');
Route::get('list-platillos', 'AdministradorController@dataPlatillos')->name('datatable.platillos');
Route::get('list-clasificaciones', 'AdministradorController@dataClasificaciones')->name('datatable.clasificaciones');