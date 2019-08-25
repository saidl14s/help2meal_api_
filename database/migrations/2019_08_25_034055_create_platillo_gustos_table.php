<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatilloGustosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platillo_gustos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('platillo_id');
            $table->unsignedBigInteger('gusto_id');
            $table->foreign('platillo_id')->references('id')->on('platillos');
            $table->foreign('gusto_id')->references('id')->on('clasificacions');
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
        Schema::dropIfExists('platillo_gustos');
    }
}
