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
        Schema::table('messes', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_type_messe');
            $table->foreign('id_type_messe')->references('id')->on('type_messes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messes', function (Blueprint $table) {
            //
        });
    }
};