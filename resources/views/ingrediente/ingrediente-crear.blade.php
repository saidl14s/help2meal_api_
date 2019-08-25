
@extends('layout.main')

@section('title', 'Registrar ingrediente') <!--title page-->

@section('content')
    <h1>Ingrediente</h1>
    <form action="{{route('admin-ingredient.store')}} " method="POST">
        @csrf
        <div class="form-group">
            <label for="">Imagen ingrediente</label>
            <input type="url" class="form-control" name="url_imagen" id="" value="https://drive.google.com/uc?export=download&id=">
        </div>
        <div class="form-group">
            <label for="">Nombre de ingrediente</label>
            <input type="text" class="form-control" name="nombre" id="" placeholder="Arroz">
        </div>
        <div class="form-group">
            <label for="">Unidad</label>
            <select class="form-control" name="unidad" id="">
                <option value="centimetro">Centimetro</option>
                <option value="litro">Litro</option>
                <option value="mililitro">Mililitro</option>
                <option value="kilogramo">Kilogramo</option>
                <option value="gramo">Gramo</option>
                <option value="miligramo">Miligramo</option>
                <option value="taza">Taza</option>
                <option value="cucharada">Cucharada</option>
                <option value="pieza">Pieza</option>
                <option value="racimo">Racimo</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Caducidad</label>
            <input type="number" class="form-control" id="" name="caducidad" placeholder="1 Días">
        </div>
        <div class="form-group">
            <label for="">Clasificación del ingrediente (grupo al que pertenece)</label>
            <select class="form-control" name="clasificacion_id" id="">
                @foreach ($clasificaciones as $clasificacion)
                    <option value="{{ $clasificacion->id }}">{{ $clasificacion->nombre }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@endsection