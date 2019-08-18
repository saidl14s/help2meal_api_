
@extends('layout.main')

@section('title', 'Registrar platillo') <!--title page-->

@section('content')
<style>

</style>
    <h1>Clasificaciones</h1>
    <form action="{{route('admin-clasificacion.store')}}" id="recipe-form" method="POST">
        @csrf
        <div class="form-group">
            <label for="">Nombre del item:</label>
            <input type="text" class="form-control" name="nombre" id="" placeholder="Categoria de ingrediente, enfermedad, etc.">
        </div>
        <div class="form-group">
            <label for="">Tipo de item</label>
            <select class="form-control" name="tipo" id="">
                <option value="ingrediente">Ingrediente</option>
                <option value="platillo">Platillo</option>
                <option value="enfermedad">Enfermedad</option>
                <option value="tiempo">Tiempo</option>
                <option value="preferencia">Gusto</option>
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>

    
@endsection