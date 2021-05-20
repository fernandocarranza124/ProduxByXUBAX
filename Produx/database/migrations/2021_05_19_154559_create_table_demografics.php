<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDemografics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demograficos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accion_id')->nullable();
            $table->foreign('accion_id')->references('id')->on('acciones');
            $table->unsignedBigInteger('emocion_id');
            $table->foreign('emocion_id')->references('id')->on('emociones');
            $table->unsignedBigInteger('edad_id');
            $table->foreign('edad_id')->references('id')->on('edades');
            $table->unsignedBigInteger('genero_id');
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
        Schema::dropIfExists('demograficos');
    }
}
