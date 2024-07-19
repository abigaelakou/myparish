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
        Schema::create('demande_messes', function (Blueprint $table) {
            $table->id();
            $table->text('intention');
            $table->text('montant');
            $table->foreignId('id_messe')->constrained('messes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_paroissien')->constrained('paroissiens')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_messes');
    }
};