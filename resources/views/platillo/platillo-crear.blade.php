
@extends('layout.main')

@section('title', 'Registrar platillo') <!--title page-->

@section('content')
    <h1>Platillo</h1>
    <form action="/" method="POST">
        <div class="form-group">
            <label for="">Nombre de platillo:</label>
            <input type="text" class="form-control" id="" placeholder="Claras con arroz y surimi">
        </div>
        <div class="form-group">
            <label for="">Comensales:</label>
            <input type="number" class="form-control" id="" placeholder="4 personas">
        </div>
        <div class="form-group">
            <label for="">Tiempo de preparación (mins)</label>
            <input type="number" class="form-control" id="" placeholder="40 mins">
        </div>
        <div class="form-group">
            <label for="">Recomendación</label>
            <select class="form-control" id="">
                <option value="desayuno">Desayuno</option>
                <option value="comida">Comida</option>
                <option value="cena">Cena</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Categoría</label>
            <select class="form-control" id="">
                <option value="cena">Comida rápida</option>
                <option value="cena">Sopas, arroces y pastas</option>
                <option value="cena">Pescados y mariscos</option>
                <option value="cena">Carnes</option>
                <option value="cena">Aves</option>
                <option value="cena">Postres</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Descripción del platillo</label>
            <textarea class="form-control" id="" rows="4"></textarea>
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@endsection