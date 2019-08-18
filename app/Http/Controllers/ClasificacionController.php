<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Clasificacion;

class ClasificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return Clasificacion::all();
        return Clasificacion::where('visible', 1)->get();
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
        //
        Clasificacion::create($request->all());
        return response()->json([
            'message'      => 'Successfully created clasification'
        ],201);
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
        $ingredientes = collect(Clasificacion::find($id)->ingredientes);
        $clasificacion = collect(Clasificacion::find($id));
        return response()->json(
                //$clasificacion->put('ingredientes',$ingredientes)->all(),
                //$ingredientes
                Clasificacion::find($id)->ingredientes, 200);
    }

    public function getEnfermedades(){
        return Clasificacion::where('tipo','enfermedad')->get();
    }

    public function getGustos(){
        return Clasificacion::where('tipo','preferencia')->get();
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
