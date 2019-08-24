
@extends('layout.main')

@section('title', 'Registrar platillo') <!--title page-->

@section('content')
<style>
fieldset{
    margin-top: 10px;
    margin-bottom: 20px;
}
h2 span{
    font-size: 18px;
}
span .unidad{
    color:cadetblue;
    font-style: italic
}
</style>
 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
 <script>tinymce.init({selector:'textarea#instruccion_s'});</script>
    <h1>Platillo</h1>
    <form action="{{route('admin-platillo.store')}}" id="recipe-form" method="POST">
        @csrf
        <div class="form-group">
            <label for=""> Imagen del platillo:</label>
            <input type="url" class="form-control" name="url_image" id="" placeholder="https://www.pexels.com/photo/burrito-chicken-delicious-dinner-461198/">
        </div>
        <div class="form-group">
            <label for="">Nombre de platillo:</label>
            <input type="text" class="form-control" name="nombre" id="" placeholder="Claras con arroz y surimi">
        </div>
        <div class="form-group">
            <label for="">Descripción del platillo</label>
            <textarea class="form-control" id="" name="descripcion" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="">Tiempo de preparación (mins)</label>
            <input type="number" class="form-control" id="" name="preparacion" placeholder="40 mins">
        </div>
        <div class="form-group">
            <label for="">Porción:</label>
            <input type="number" class="form-control" name="porcion" placeholder="4 personas">
        </div>
        <div class="form-group">
            <label for="">Tipo de porción</label>
            <select class="form-control" name="porcion_tipo" id="">
                <option value="pieza">Pieza</option>
                <option value="persona">Persona</option>
            </select>
        </div>
        <div class="form-group">
            <label for=""> Recomendación</label>
            <select class="form-control" name="tipo_recomendacion" id="">
                    @foreach ($tiempos_comida as $tiempo)
                        <option value="{{ strtolower($tiempo->nombre) }}">{{ $tiempo->nombre }}</option>
                    @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Instrucciones</label>
            <textarea name="instrucciones" id="instruccion_s"></textarea>
        </div>
        <div class="row">
            <div class="col">
                <h2>Ingredientes</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($ingredientes as $ingrediente)
                <div class="col">
                    <input type="number" name="ingrendientes[{{ $ingrediente->id }}]" value="0" id="c_ingrediente-{{ $ingrediente->id }}">
                    <div class="form-group form-check">
                            {{ $ingrediente->nombre }} <br> <span class="unidad"> {{ $ingrediente->unidad }}</span>
                        <!--<input type="checkbox" class="form-check-input" name="ingrendientes[]" value="{{ $ingrediente->id }}" id="ingrediente-{{ $ingrediente->id }}">
                        <label class="form-check-label" for="ingrediente-{{ $ingrediente->id }}">{{ $ingrediente->nombre }}</label>-->
                    </div>        
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col">
                <h2>Prohibir <span> a personas con:</span></h2>
            </div>
        </div>
        <div class="row">
            @foreach ($enfermedades as $enfermedad)
                <div class="col">
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" name="enfermedades[]" value="{{ $enfermedad->id }}" id="enfermedad-{{ $enfermedad->id }}">
                        <label class="form-check-label" for="enfermedad-{{ $enfermedad->id }}">{{ $enfermedad->nombre }}</label>
                    </div>        
                </div>
            @endforeach
        </div>
        <br>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@endsection