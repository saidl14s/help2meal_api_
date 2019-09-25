<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use \App\Platillo;
use \App\PlatilloIngrediente;
use \App\PlatilloEnfermedad;
use \App\Ingrediente;
use \App\PlatilloUsuario;
use \App\PlatilloGusto;
use \App\User;
use \App\UsuarioEnfermedad;
use \App\UsuarioIngrediente;
use \App\UsuarioGusto;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlatilloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Platillo::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->json([
            'message'      => 'Service temporarily unavailable'
        ],503);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //'nombre', 'descripcion', 'preparacion','porcion,','porcion_tipo','instrucciones'
        $recipe = Platillo::create([
            'url_image' => $request->input('url_image'),
            'nombre' => $request->input('nombre'),
            'descripcion'=> $request->input('descripcion'),
            'preparacion' => $request->input('preparacion'),
            'porcion' => $request->input('porcion'),
            'porcion_tipo' => $request->input('porcion_tipo'),
            'tipo_recomendacion' => $request->input('tipo_recomendacion'), 
            'instrucciones'=> $request->input('instrucciones')
        ]);
        
        $ingredientes = $request->input('ingrendientes');
        foreach($ingredientes as $id_ingrediente => $cantidad) {
            if($cantidad > 0){
                PlatilloIngrediente::create([
                    'ingrediente_id' => $id_ingrediente,
                    'platillo_id' => $recipe->id,
                    'cantidad' => $cantidad
                ]);
            }
            
        }

        $enfermedades_receive = $request->input('enfermedades');
        foreach ($enfermedades_receive as $enfermedad ) {
            PlatilloEnfermedad::create([
                'enfermedad_id' => $enfermedad,
                'platillo_id' => $recipe->id
            ]);
        }

        $preferencias = $request->input('preferencias');
        foreach ($preferencias as $preferencia ) {
            PlatilloGusto::create([
                'gusto_id' => $preferencia,
                'platillo_id' => $recipe->id
            ]);
        }
        
        return response()->json([
            'message'      => 'Successfully created recipe'
        ],201);   
        
    }

    public function lastRecipes(Request $request){
        // return $request;
        $results = array();

        $results_db = PlatilloUsuario::where('user_id', $request->user()->id)->take(6)->get();
        foreach ($results_db as $result) {
            $recipe = Platillo::find($result->platillo_id);
            $new_recipe = [
                'id' => $recipe->id,
                'url_image' => $recipe->url_image
            ];
            $results[] = $new_recipe;
        }
       
        return $results;
    }

    public function newsRecipes(){

        /*return [
                [ 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
                [ 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
                [ 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
                [ 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            ];*/
        $new_recipes = array();

        $results_db = Platillo::orderBy('id', 'desc')->take(4)->get();
        foreach ($results_db as $result) {
            $new_recipe = [
                'url_image' => $result->url_image
            ];
            $new_recipes[] = $new_recipe;
        }
        
        return $new_recipes;
        
    }
    public function history(Request $request){
        
        $results = array();

        $results_db = PlatilloUsuario::where('user_id', $request->user()->id)->get();
        foreach ($results_db as $result) {
            $recipe = Platillo::find($result->platillo_id);
            $new_recipe = [
                'id' => $recipe->id,
                'nombre'=> $recipe->nombre,
                'descripcion' => $recipe->descripcion,
                'descripcion'=> $recipe->descripcion,
                'url_image' => $recipe->url_image
            ];
            $results[] = $new_recipe;
        }
       
        return $results;
    }

    public function updateUser(Request $request){

        // registrarle al usuario el platillo como ya cocinado
        try{
            $recipe_exist = PlatilloUsuario::where([
                ['platillo_id', '=', $request->input('platillo_id')],
                ['user_id', '=', $request->user()->id]
            ])->firstOrFail();
        }catch(ModelNotFoundException $e){
            $recipe = PlatilloUsuario::create([
                'platillo_id' => $request->input('platillo_id'),
                'user_id' => $request->user()->id,
            ]);
        }

        // actualizar el inventario del usuario
        
        $user_all_ingredients = UsuarioIngrediente::where('user_id', $request->user()->id )->get();
        $ingredients_user = array();
        foreach ($user_all_ingredients as $ingredient) {
            $ingredients_user[] = $ingredient->ingrediente_id;
        }

        $recipe_all_ingredients = PlatilloIngrediente::where('platillo_id', $request->input('platillo_id') )->get();
        $ingredients_recipe = array();
        $cantidades_recipe = array();
        $nombre_recipe = array();
        foreach ($recipe_all_ingredients as $ingredient) {
            $ingredients_recipe[] = $ingredient->ingrediente_id;
            $cantidades_recipe[] = $ingredient->cantidad;
            //$nombre_recipe[] = $ingredient->nombre;
            $tempIngredient = Ingrediente::find($ingredient->ingrediente_id);
            $nombre_recipe[] = $tempIngredient->nombre;
        }
        
        $ingredients_coincidencias_ = array_intersect($ingredients_recipe, $ingredients_user);
        $index_ = 0;
        $message_ = "";
        foreach ($ingredients_coincidencias_ as $ingredient) {
            $cantidad_recipe = $cantidades_recipe[$index_];
            try{
                $ingredient_exist = UsuarioIngrediente::where([
                    ['ingrediente_id', '=', $ingredient],
                    ['user_id', '=', $request->user()->id]
                ])->firstOrFail();
                if( $cantidad_recipe < $ingredient_exist->cantidad){
                    $ingredient_exist->cantidad = $ingredient_exist->cantidad - $cantidad_recipe;
                    $ingredient_exist->save();
                    //$message_ .= " Se agrego";
                }else{
                    //$ingredient_exist->cantidad = 0;
                    $ingredient_exist->delete();
                    $message_ .= "Ya no te queda más de ".$nombre_recipe[$index_] . " te recomendamos surtirlo de nuevo.";
                }
            }catch(ModelNotFoundException $e){}
            $index_++;
        }
        if($message_ != ""){
            return response()->json([
                'message'      => $message_
            ], 201);
        }else{
            return response()->json([
                'message'      => null
            ], 200);
        }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Platillo::find($id);
        /*$recipe = Platillo::find($id);
        $ingredients = PlatilloIngrediente::where('platillo_id', $recipe->id )->get();
        $info_ingredient = array();
        $all_ingredients = array();
        foreach($ingredients as $ingredient){
            $ing = Ingrediente::find($ingredient->ingrediente_id);
            $count = $ingredient->cantidad;
            $info_ingredient = Arr::add($ing, 'cantidad', $count);
            $all_ingredients[]=$info_ingredient;
            //$array = Arr::add($recipe, 'ingredients',$info_ingredient);
        }
        $array = Arr::add($recipe, 'ingredients',$all_ingredients);
        return $array;*/
    }

    public function getIngredientRecipe($id)
    {
        //
        //return Platillo::find($id);
        $recipe = Platillo::find($id);
        $ingredients = PlatilloIngrediente::where('platillo_id', $recipe->id )->get();
        $info_ingredient = array();
        $all_ingredients = array();
        foreach($ingredients as $ingredient){
            $ing = Ingrediente::find($ingredient->ingrediente_id);
            $count = $ingredient->cantidad;
            $info_ingredient = Arr::add($ing, 'cantidad', $count);
            $all_ingredients[]=$info_ingredient;
            //$array = Arr::add($recipe, 'ingredients',$info_ingredient);
        }
        $array = Arr::add($recipe, 'ingredients',$all_ingredients);
        return $all_ingredients;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    /// v2
    public function getIngredientRecipev2(Request $request)
    {
        //
        $id = $request->input('platillo_id');
        //return Platillo::find($id);
        $recipe = Platillo::find($id);
        $ingredients = PlatilloIngrediente::where('platillo_id', $recipe->id )->get();
        $info_ingredient = array();
        $all_ingredients = array();
        foreach($ingredients as $ingredient){
            $ing = Ingrediente::find($ingredient->ingrediente_id);
            $count = $ingredient->cantidad;
            $info_ingredient = Arr::add($ing, 'cantidad', $count);

            try{
                $user_exist = UsuarioIngrediente::where([
                    ['ingrediente_id', '=', $ingredient->ingrediente_id ],
                    ['user_id', '=', $request->user()->id]
                ])->firstOrFail();
                //$info_ingredient = Arr::add($info_ingredient, 'user_exist', true);
                //$all_ingredients[]=$info_ingredient;
            }catch(ModelNotFoundException $e){
                //$info_ingredient = Arr::add($info_ingredient, 'user_exist', false);
                $all_ingredients[]=$info_ingredient;
            }

            
            //$array = Arr::add($recipe, 'ingredients',$info_ingredient);
        }
        return $all_ingredients;
    }

    public function getIngredientUserRecipev2(Request $request)
    {
        //
        $id = $request->input('platillo_id');
        //return Platillo::find($id);
        $recipe = Platillo::find($id);
        $ingredients = PlatilloIngrediente::where('platillo_id', $recipe->id )->get();
        $info_ingredient = array();
        $all_ingredients = array();
        foreach($ingredients as $ingredient){
            $ing = Ingrediente::find($ingredient->ingrediente_id);
            $count = $ingredient->cantidad;
            $info_ingredient = Arr::add($ing, 'cantidad', $count);

            try{
                $user_exist = UsuarioIngrediente::where([
                    ['ingrediente_id', '=', $ingredient->ingrediente_id ],
                    ['user_id', '=', $request->user()->id]
                ])->firstOrFail();
                //$info_ingredient = Arr::add($info_ingredient, 'user_exist', true);
                $all_ingredients[]=$info_ingredient;
            }catch(ModelNotFoundException $e){
                //$info_ingredient = Arr::add($info_ingredient, 'user_exist', false);
                //$all_ingredients[]=$info_ingredient;
            }

            
            //$array = Arr::add($recipe, 'ingredients',$info_ingredient);
        }
        return $all_ingredients;
    }
    

    public function ai(Request $request){

        $first_filter = array(); // enfermedades
        $second_filter = array(); // gusto
        $third_filter = array(); // match ingredientes

        $user_ = $request->user()->id;
        $gustos_user = UsuarioGusto::where('user_id', $user_ )->get();
        $enfermedades_user = UsuarioEnfermedad::where('user_id', $user_ )->get();
        $ingredientes_user = UsuarioIngrediente::where('user_id', $user_ )->get();

        $gustos_ = array();
        foreach ($gustos_user as $gusto_user) {
            $gustos_[] = $gusto_user->gusto_id;
        }
        // ENEIT
        /*if(count($gustos_) == 0){
            $all_ =  Clasificacion::where('tipo', 'preferencia' )->get();
            foreach ($all_ as $gusto_user) {
                $gustos_[] = $gusto_user->gusto_id;
            }
        }*/
        // ENEIT

        $enfermedades_ = array();
        foreach ($enfermedades_user as $enfermedad_user) {
            $enfermedades_[] = $enfermedad_user->enfermedad_id;
        }

        $ingredientes_ = array();
        foreach ($ingredientes_user as $ingrediente_user) {
            $ingredientes_[] = $ingrediente_user->ingrediente_id;
        }

        $recipes = Platillo::where('tipo_recomendacion', $request->input('tipo_recomendacion'))->get();

        foreach($recipes as $recipe){
            $temp_enfermedades = array();

            $prohibido = PlatilloEnfermedad::where('platillo_id', $recipe->id)->get();
            
            foreach ($prohibido as $enfermedad) {
                $temp_enfermedades[] = $enfermedad->enfermedad_id;
            }
            $enfemedades_coincidencias_ = array_intersect($temp_enfermedades, $enfermedades_);
            if( count( $enfemedades_coincidencias_ ) == 0 ){
                $first_filter[] = $recipe;
            }

        }

        foreach($first_filter as $recipe){
            $temp_gustos = array();

            $gustos = PlatilloGusto::where('platillo_id', $recipe->id)->get();
            foreach ($gustos as $gusto) {
                $temp_gustos[] = $gusto->gusto_id;
            }
            $gustos_coincidencias_ = array_intersect($temp_gustos, $gustos_);
            if( count( $gustos_coincidencias_ ) > 0 ){
                $second_filter[] = $recipe;
            }
        }

        // ultimo filtro es para coincidencia entre ingredientes
        /**
         * 
        */
        $temp_ingredientes_user = array();
        foreach ($ingredientes_user as $ingrediente) {
            $temp_ingredientes_user[] = $ingrediente->ingrediente_id;
        }

        foreach($second_filter as $recipe){
            $temp_ingredients = array();

            $ingredientes = PlatilloIngrediente::where('platillo_id', $recipe->id)->get();
            foreach ($ingredientes as $ingrediente) {
                $temp_ingredients[] = $ingrediente->ingrediente_id;
            }

            $limit = count( $temp_ingredients );

            $ingredientes_coincidencias_ = array_intersect($temp_ingredients, $temp_ingredientes_user);

            $num_coincidencias =  count( $ingredientes_coincidencias_ ) ;
            if($num_coincidencias >= ($limit / 2)){ // mayor o igual que el numero total de ingredientes
                $third_filter[] = $recipe;
                //$third_filter[] = $num_coincidencias;
            }
        }
            
        // ordenar el third_filter conforme a mayor numero de coincidencia entre ingredientes
        /* * */

        if(count ( $third_filter ) > 0 )        
            return $third_filter; // third_filter second_filter first_filter
        else // recipe null
            return response()->json([
                [
                'id' => 0,
                'nombre' => '¡Lo sentimos! No encontramos alguna receta adecuada para ti',
                'descripcion' => '',
                'url_image' => 'https://drive.google.com/uc?export=download&id=1mqAXpz03koHJABInjAg7PYJk52xCsJNY'
                ]
            ]);
        
    }
}
