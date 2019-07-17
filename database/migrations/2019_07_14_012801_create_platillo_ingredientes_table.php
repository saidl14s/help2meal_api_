<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatilloIngredientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platillo_ingredientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ingrediente_id');
            $table->unsignedBigInteger('platillo_id');
            $table->unsignedBigInteger('cantidad');
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes');
            $table->foreign('platillo_id')->references('id')->on('platillos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platillo_ingredientes');
    }
}
