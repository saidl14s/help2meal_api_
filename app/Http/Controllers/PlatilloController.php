<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

use \App\Platillo;
use \App\PlatilloIngrediente;
use \App\Ingrediente;

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

        $instruccion_images = $request->input('url_instrucction');
        $instruccion_content = $request->input('content_instrucction');
        
        $instrucciones = array($instruccion_images,$instruccion_content );
        $instrucciones = json_encode($instrucciones);

        //'nombre', 'descripcion', 'preparacion','porcion,','porcion_tipo','instrucciones'
        $recipe = Platillo::create([
            'url_image' => $request->input('url_image'),
            'nombre' => $request->input('nombre'),
            'descripcion'=> $request->input('descripcion'),
            'preparacion' => $request->input('preparacion'),
            'porcion' => $request->input('porcion'),
            'porcion_tipo' => $request->input('porcion_tipo'),
            'tipo_recomendacion' => $request->input('tipo_recomendacion'), 
            'instrucciones'=> $instrucciones
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
        return response()->json([
            'message'      => 'Successfully created recipe'
        ],201);
    }

    public function lastRecipes(Request $request){
       // return $request;
       return [
            [ 'id'=>'2', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'4', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'1', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'3', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'5', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'6', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
        ];
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
        
        
        //$ingredients = PlatilloIngrediente::where('platillo_id', $request->input('tipo_recomendacion'))->get();
        //return $recipes;
    
        /*return [
            [ 'id'=>'5', 'nombre' => 'Chilitos rellenos', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'3', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'1', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'3', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'5', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'6', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
        ];*/
        
    }

    public function history(){
        return [
            [ 'id'=>'2', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'4', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'1', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'3', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'5', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'6', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
        ];
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
