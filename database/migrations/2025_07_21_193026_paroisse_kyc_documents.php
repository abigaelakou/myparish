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
        //
    Schema::create('paroisse_kyc_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paroisse_id')->constrained()->onDelete('cascade');
            $table->string('type_document'); // ex: 'rccm', 'identite', etc.
            $table->string('chemin_fichier');
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
          Schema::dropIfExists('paroisse_kyc_documents');
    }
};
