<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\User;
use App\Ingrediente;
use App\Platillo;
use App\Clasificacion;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.index');
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

    /* Method for login web */
    public function showLogin(){
        return view('admin.login');
    }

    public function clienLogin(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return view('admin.index');
        }else{
            return redirect()->route('login')->with('status', 'Usuario y/o contraseña invalido.');
        }
    }

    public function createRecipe(){
        return view('platillo.platillo-crear',[
            'ingredientes' => Ingrediente::all(),
            'enfermedades' => Clasificacion::where('tipo','enfermedad')->get(),
            'tiempos_comida' => Clasificacion::where('tipo','tiempo')->get(),
        ]);
    }
    
    public function createClassification(){
        return view('clasificacion.clasificacion-crear');
    }
    

    /* Custom methods for datatable*/
    public function dataIngredientes()
    {
        return Datatables::of(Ingrediente::query())->make(true);
    }

    public function dataPlatillos()
    {
        return Datatables::of(Platillo::query())->make(true);
    }

    public function dataClasificaciones()
    {
        return Datatables::of(Clasificacion::query())->make(true);
    }
    
}
