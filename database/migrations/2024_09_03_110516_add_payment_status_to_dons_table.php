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
        Schema::table('dons', function (Blueprint $table) {
            //
            $table->enum('payment_status', ['En attente', 'Payé', 'Echec'])->default('En attente')->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dons', function (Blueprint $table) {
            //
        });
    }
};
