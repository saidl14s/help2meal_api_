<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \App\Ingrediente;
use \App\Clasificacion;
use \App\User;
use \App\UsuarioIngrediente;
use \App\PlatilloUsuario;

class IngredienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return Ingrediente::all();
    }
    
    public function indexInventary(Request $request)
    {
        //
        $ingredients = array();
        $ingredients_db = Ingrediente::all();
        foreach ($ingredients_db as $ingredient_db) {
            //$ingredient_db->id;
            try{
                $ingredient_user = UsuarioIngrediente::where([
                    ['ingrediente_id', '=', $ingredient_db->id],
                    ['user_id', '=', $request->user()->id]
                ])->firstOrFail();
                $ingredient_db->cantidad = $ingredient_user->cantidad;    
            }catch(ModelNotFoundException $e){
                $ingredient_db->cantidad = 0;
            }
            $ingredients[] = $ingredient_db;
        }
        
        return $ingredients;
        
        //return Ingrediente::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('ingrediente.ingrediente-crear');
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
        try{
            $clasificacion = Clasificacion::where([
                ['nombre', '=', $request->input('clasificacion')],
            ])->firstOrFail();
            Ingrediente::create([
                'nombre' => $request->input('nombre'),
                'unidad' => $request->input('unidad'),
                'caducidad' => $request->input('caducidad'),
                'clasificacion_id' => $clasificacion->id,
                'url_imagen' => $request->input('url_imagen'),
            ]);
            return response()->json([
                'message'      => 'Successfully created ingredient'
            ],201);
        }catch(ModelNotFoundException $e){}
        
        
    }

    public function saveUser(Request $request){
        try{
            $ingredient_exist = UsuarioIngrediente::where([
                ['ingrediente_id', '=', $request->input('ingrediente_id')],
                ['user_id', '=', $request->user()->id]
            ])->firstOrFail();
            if($request->input('cantidad') == 0){
                $ingredient_exist->delete();
                return response()->json([
                    'message'      => 'Successfully deleted registry'
                ],201);
            }else{
                $ingredient_exist->cantidad = $request->input('cantidad');
                $ingredient_exist->save();

                return response()->json([
                    'message'      => 'Successfully update registry'
                ],201);
            }
        }catch(ModelNotFoundException $e){
            UsuarioIngrediente::create([
                'ingrediente_id' => $request->input('ingrediente_id'),
                'user_id' => $request->user()->id,
                'cantidad' => $request->input('cantidad'),
            ]);
            return response()->json([
                'message'      => 'Successfully create registry'
            ],201);
        }
        
        //return $exist;
    }

    public function updateUser(Request $request){
        try{
            $ingredient_exist = UsuarioIngrediente::where([
                ['ingrediente_id', '=', $request->input('ingrediente_id')],
                ['user_id', '=', $request->user()->id]
            ])->firstOrFail();
            if( $request->input('cantidad') < $ingredient_exist->cantidad){
                $ingredient_exist->cantidad = $ingredient_exist->cantidad - $request->input('cantidad');
                $ingredient_exist->save();
            }else{
                //$ingredient_exist->cantidad = 0;
                $ingredient_exist->delete();
            }
        }catch(ModelNotFoundException $e){}
   
    }

    public function getIngredientClasificacions(){
        $clasificaciones = array();
        $clasificaciones_db = Clasificacion::where('tipo','ingrediente')->get();
        foreach ($clasificaciones_db as $clasificacion_db) {
            $pre_ = [
                'id' => $clasificacion_db->id,
                'nombre' =>$clasificacion_db->nombre,
            ];
            $clasificaciones[] = $pre_;
        }
        return $clasificaciones;
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
        $clasificacion = collect(Ingrediente::find($id)->clasificacion);
        $ingrediente = collect(Ingrediente::find($id));
        return response()->json(
            [
                $ingrediente->put('clasificacion',$clasificacion)->all(),
            ], 200);
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
        return response()->json([
            'message' => 'Unauthorized'], 401);
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
        return response()->json([
            'message' => 'Unauthorized'], 401);
    }

}
