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
        Schema::create('historique_actions', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // Description de l'action
            $table->text('details')->nullable(); // Détails supplémentaires
            // $table->timestamp('created_at')->useCurrent(); // Date et heure de l'action
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('paroisse_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('paroisse_id')->references('id')->on('paroisses')->onDelete('cascade');
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
        Schema::dropIfExists('historique_actions');
    }
};
