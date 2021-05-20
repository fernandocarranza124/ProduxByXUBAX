<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAtencionCamposToDemograficos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demograficos', function (Blueprint $table) {
            $table->unsignedBigInteger('duracion');
            $table->boolean('atencion');
            $table->unsignedBigInteger('persona_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demograficos', function (Blueprint $table) {
            //
        });
    }
}
