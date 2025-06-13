<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pain_jours', function (Blueprint $table) {
            //
            $table->boolean('est_auto')->default(false); // Pour savoir si c'est généré automatiquement
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pain_jours', function (Blueprint $table) {
            //
        });
    }
};
