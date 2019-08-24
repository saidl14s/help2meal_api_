<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioEnfermedadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_enfermedads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('enfermedad_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('enfermedad_id')->references('id')->on('clasificacions');
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
        Schema::dropIfExists('usuario_enfermedads');
    }
}
