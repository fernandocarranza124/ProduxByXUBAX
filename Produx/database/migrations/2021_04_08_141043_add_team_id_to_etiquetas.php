<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamIdToEtiquetas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etiquetas', function (Blueprint $table) {
            $table->foreignId('team_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etiquetas', function (Blueprint $table) {
            $table->foreignId('team_id');
        });
    }
}
