<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionesEtiquetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etiquetas_dispositivo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->foreignId('etiqueta_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('etiquetas_dispositivo');
    }
}
