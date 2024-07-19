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
        Schema::create('catechumenes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->string('email');
            $table->string('nom_prenom_pere');
            $table->string('contact_pere');
            $table->string('nom_prenom_mere');
            $table->string('contact_mere');
            $table->string('nom_prenom_parain');
            $table->string('contact_parain');
            $table->enum('sacrement_recu', ['AUCUN', 'BAPTEME', 'EUCHARISTIE', 'CONFIRMATION', 'ONCTION DES MALADE', 'MARIAGE', 'RECONCILIATION',]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catechumenes');
    }
};