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
        Schema::create('paiements_catechese', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_inscription')->constrained('inscriptions')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->string('mode_paiement')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('contact')->nullable();
            $table->enum('payment_status', ['En attente', 'Payé', 'Échec'])->default('En attente');
            $table->date('date_paiement')->nullable();
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
        Schema::dropIfExists('paiements_catechese');
    }
};