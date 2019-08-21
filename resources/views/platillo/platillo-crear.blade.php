
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
</style>
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
            <button type="button" onclick="addInstruccion()">+</button>
            <div id="container_instrucciones">

            </div>
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
                            {{ $ingrediente->nombre }}
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

    <script>
        var item_instruction = "<fieldset><input type='text' class='form-control' name='url_instrucction[]'  placeholder='https://www.pexels.com/photo/green-petaled-flower-2395250/'><textarea class='form-control' name='content_instrucction[]' rows='4'></textarea></fieldset>";
        function addInstruccion(){
            document.getElementById("container_instrucciones").innerHTML += item_instruction;
        }

        /*function prepareJSONinstructions(){
            var json_instructions ;

            var steps_images = document.forms['recipe-form'].elements[ 'url_instrucction[]' ];
            var steps_content = document.forms['recipe-form'].elements[ 'content_instrucction[]' ];

            if( steps_images.length ==  steps_content.length){
                for (var i=0; i < steps_images.length; i++) {
                    var instrucction = new Object();
                    instrucction.step = i+1;
                    instrucction.content = steps_content[i].value;
                    instrucction.url_image = steps_images[i].value;

                    json_instructions += JSON.stringify(instrucction);
                }

                //document.getElementById("instructions_json").value = ""+json_instructions;
                
                sendForm();
            }
            
        }

        function sendForm(){
            document.getElementById("recipe-form").submit();
        }*/
    </script>
@endsection