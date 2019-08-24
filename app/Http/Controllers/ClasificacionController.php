<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \App\Clasificacion;
use \App\UsuarioEnfermedad;
use \App\UsuarioGusto;

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

    public function showIngredientes(){
        return Clasificacion::where('tipo', 'ingrediente')->get();
    }

    
    public function indexGustosUser(Request $request)
    {
        //
        $gustos = array();
        $gustos_db = Clasificacion::where('tipo', 'preferencia')->get();
        foreach ($gustos_db as $gusto_db) {
            try{
                $gusto_user = UsuarioGusto::where([
                    ['gusto_id', '=', $gusto_db->id],
                    ['user_id', '=', $request->user()->id]
                ])->firstOrFail();
                $gusto_db->activo = true;
            } catch(ModelNotFoundException $e){
                $gusto_db->activo = false;
            }
            $gustos[] = $gusto_db;
        }
        return $gustos;
        
        //return Ingrediente::all();
    }

    public function indexPreferencesUser(Request $request)
    {
        //
        $diseases = array();
        $diseases_db = Clasificacion::where('tipo', 'enfermedad')->get();
        foreach ($diseases_db as $disease_db) {
            try{
                $disease_user = UsuarioEnfermedad::where([
                    ['enfermedad_id', '=', $disease_db->id],
                    ['user_id', '=', $request->user()->id]
                ])->firstOrFail();
                $disease_db->activo = true;
            } catch(ModelNotFoundException $e){
                $disease_db->activo = false;
            }
            $diseases[] = $disease_db;
        }
        return $diseases;
        
        //return Ingrediente::all();
    }

    public function saveGustosUser(Request $request){
        try{
            $gust_exist = UsuarioGusto::where([
                ['gusto_id', '=', $request->input('gusto_id')],
                ['user_id', '=', $request->user()->id]
            ])->firstOrFail();
            if($request->input('activo') == 'false'){
                $gust_exist->delete();
            }
        }catch(ModelNotFoundException $e){
            if($request->input('activo') == 'true'){
                UsuarioGusto::create([
                    'gusto_id' => $request->input('gusto_id'),
                    'user_id' => $request->user()->id
                ]);
            }
        }
    }

    public function saveEnfermedadesUser(Request $request){
        try{
            $gust_exist = UsuarioEnfermedad::where([
                ['enfermedad_id', '=', $request->input('enfermedad_id')],
                ['user_id', '=', $request->user()->id]
            ])->firstOrFail();
            if($request->input('activo') == 'false'){
                $gust_exist->delete();
            }
        }catch(ModelNotFoundException $e){
            if($request->input('activo') == 'true'){
                UsuarioEnfermedad::create([
                    'enfermedad_id' => $request->input('enfermedad_id'),
                    'user_id' => $request->user()->id
                ]);
            }
        }
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
