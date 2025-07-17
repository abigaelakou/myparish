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
        Schema::table('demande_messes', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_type_intention');
            $table->foreign('id_type_intention')->references('id')->on('type_intentions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demande_messes', function (Blueprint $table) {
            //
        });
    }
};