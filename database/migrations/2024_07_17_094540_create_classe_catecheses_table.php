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
        Schema::create('classe_catecheses', function (Blueprint $table) {
            $table->id();
            $table->string('lib_classe_cate');
            $table->foreignId('id_niveau')->constrained('niveau_catechetiques')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_catecheses');
    }
};