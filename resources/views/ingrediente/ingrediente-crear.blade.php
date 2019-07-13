
@extends('layout.main')

@section('title', 'Registrar ingrediente') <!--title page-->

@section('content')
    <h1>Ingrediente</h1>
    <form action="/" method="POST">
        <div class="form-group">
            <label for="">Nombre de ingrediente</label>
            <input type="text" class="form-control" id="" placeholder="Arroz">
        </div>
        <div class="form-group">
            <label for="">Unidad</label>
            <select class="form-control" id="">
                <option value="desayuno">Centimetro</option>
                <option value="desayuno">Litro</option>
                <option value="cena">Kilogramo</option>
                <option value="cena">Gramo</option>
                <option value="cena">Miligramo</option>
                <option value="cena">Taza</option>
                <option value="comida">Pieza</option>
                <option value="cena">Cucharada</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Cantidad</label>
            <input type="number" class="form-control" id="" placeholder="1.4">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@endsection