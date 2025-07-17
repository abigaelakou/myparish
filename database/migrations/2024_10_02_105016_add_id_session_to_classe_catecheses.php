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
        Schema::table('classe_catecheses', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_session');
            $table->foreign('id_session')->references('id')->on('session_catecheses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classe_catecheses', function (Blueprint $table) {
            //
        });
    }
};