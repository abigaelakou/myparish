<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paroissiens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact')->unique();
            $table->string('email')->unique();
            $table->string('sexe');
            $table->string('situation_matrimoniale');
            $table->date('date_naiss');
            $table->date('date_inscription');
            $table->enum('sacrement_recu', ['AUCUN', 'BAPTEME', 'EUCHARISTIE', 'CONFIRMATION', 'ONCTION DES MALADE', 'MARIAGE', 'RECONCILIATION',]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paroissiens');
    }
};
