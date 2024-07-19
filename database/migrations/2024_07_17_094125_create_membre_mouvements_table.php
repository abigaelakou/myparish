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
        Schema::create('membre_mouvements', function (Blueprint $table) {
            $table->id();
            $table->string('name_membre');
            $table->string('contact')->unique();
            $table->date('date_inscription');
            $table->enum('role_membre', ['MEMBRE SIMPLE', 'RESPONSABLE', 'MEMBRE BUREAU']);
            $table->foreignId('id_mouvement')->constrained('mouvements')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membre_mouvements');
    }
};