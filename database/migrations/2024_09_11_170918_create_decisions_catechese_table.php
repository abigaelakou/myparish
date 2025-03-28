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
        Schema::create('decisions_catechese', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_catechumene')->constrained('catechumenes')->onDelete('cascade');
            $table->string('annee_catechetique');
            $table->string('moy_final');
            $table->integer('total_presence_catechese')->default(0);
            $table->integer('total_presence_messes')->default(0);
            $table->integer('total_presence_ceb')->default(0);
            $table->enum('decision_finale', ['Admis', 'Recalé', 'Abandon', 'Clôturé'])->default('Admis');
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
        Schema::dropIfExists('decisions_catechese');
    }
};