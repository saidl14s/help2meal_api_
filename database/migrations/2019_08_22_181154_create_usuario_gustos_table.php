<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioGustosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_gustos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('gusto_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('gusto_id')->references('id')->on('clasificacions');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('usuario_gustos');
    }
}
