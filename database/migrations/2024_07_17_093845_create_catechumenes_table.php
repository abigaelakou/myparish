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
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('nom_prenom_pere');
            $table->string('contact_pere')->nullable();
            $table->string('nom_prenom_mere');
            $table->string('contact_mere')->nullable();
            $table->string('nom_prenom_parain')->nullable();
            $table->string('contact_parain')->nullable();
            $table->string('sacrement_recu');
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