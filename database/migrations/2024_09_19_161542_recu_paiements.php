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
        Schema::create('recu_paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_paiement')->constrained('paiements_catechese')->onDelete('cascade');
            $table->string('nom_prenom');
            $table->string('montant');
            $table->string('contact');
            $table->date('date_paiement');
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
    }
};