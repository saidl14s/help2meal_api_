<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeToPlatillosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('platillos', function (Blueprint $table) {
            //tipo_recomendacion
            $table->string('tipo_recomendacion');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('platillos', function (Blueprint $table) {
            //
            $table->dropColumn('tipo_recomendacion');
        });
    }
}
