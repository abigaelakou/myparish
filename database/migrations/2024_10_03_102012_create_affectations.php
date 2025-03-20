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
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_catechumene');
            $table->foreign('id_catechumene')->references('id')->on('catechumenes')->onDelete('cascade');
            $table->unsignedBigInteger('id_classe');
            $table->foreign('id_classe')->references('id')->on('classe_catecheses')->onDelete('cascade');
            $table->date('date_affectation');
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