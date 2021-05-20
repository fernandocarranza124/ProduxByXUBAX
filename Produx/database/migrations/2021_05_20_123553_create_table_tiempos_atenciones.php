<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTiemposAtenciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiempos_atenciones', function (Blueprint $table) {
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('atencion_id');
            $table->unsignedBigInteger('duracion');
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
        Schema::dropIfExists('tiempos_atenciones');
    }
}
