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
        Schema::table('membre_mouvements', function (Blueprint $table) {
            $table->unsignedBigInteger('paroisse_id')->nullable();  // Colonne pour la paroisse
            $table->foreign('paroisse_id')->references('id')->on('paroisses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membre_mouvements', function (Blueprint $table) {
            //
        });
    }
};
