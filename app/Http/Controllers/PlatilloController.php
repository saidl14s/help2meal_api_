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


        $enfermedades = $request->input('enfermedades');
        foreach ($enfermedades as $enfermedad) {
            PlatilloEnfermedad::create([
                'enfermedad_id' => $enfermedad->id,
                'platillo_id' => $recipe->id
            ]);
        }

        $preferencias = $request->input('preferencias');
        foreach ($preferencias as $preferencia) {
            PlatilloGusto::create([
                'gusto_id' => $preferencia->id,
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

        $results_db = PlatilloUsuario::where('user_id', $request->user()->id)->get();
        foreach ($results_db as $result) {
            $recipe = Platillo::find($result->id);
            $new_recipe = [
                'id' => $recipe->id,
                'url_image' => $recipe->url_image
            ];
            $results[] = $new_recipe;
        }
       
        return $results;
    }

    public function ai(Request $request){
        $all_recipes = array();
        $recipes = Platillo::where('tipo_recomendacion', $request->input('tipo_recomendacion'))->get();
        foreach($recipes as $recipe){
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
            $all_recipes[]= $array;
        }
        return $all_recipes;
        
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
            $recipe = Platillo::find($result->id);
            $new_recipe = [
                'id' => $recipe->id,
                'nombre'=>$recipe->nombre,
                'descripcion'=>$recipe->descripcion,
                'descripcion'=>$recipe->descripcion,
                'url_image' => $recipe->url_image
            ];
            $results[] = $new_recipe;
        }
       
        return $results;
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
}
