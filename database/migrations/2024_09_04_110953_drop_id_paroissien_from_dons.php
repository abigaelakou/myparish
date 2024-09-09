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
            $table->dropForeign(['id_paroissien']);
            $table->dropColumn('id_paroissien');
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
            $table->unsignedBigInteger('id_paroissien')->nullable();
            $table->foreign('id_paroissien')->references('id')->on('paroissiens')->onDelete('cascade');
        });
    }
};
