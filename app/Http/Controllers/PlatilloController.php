<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Platillo;

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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ingredientes = $request->input('ingrendientes');

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
            //'tipo_recomendacion' => $request->input('tipo_recomendacion'), 
            'instrucciones'=> $instrucciones
        ]);
        return response()->json([
            'message'      => 'Successfully created recipe'
        ],201);
        //return $request;
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
        return [
            [ 'id'=>'2', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'4', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'1', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'3', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'5', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
            [ 'id'=>'6', 'nombre' => 'Arroz', 'descripcion' => 'lorem', 'url_image'=>'https://images.pexels.com/photos/1860207/pexels-photo-1860207.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940'],
        ];
        
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
