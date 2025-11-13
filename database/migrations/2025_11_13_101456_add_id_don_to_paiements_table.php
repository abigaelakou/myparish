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
        Schema::table('paiements', function (Blueprint $table) {
            if (!Schema::hasColumn('paiements', 'id_don')) {
                $table->foreignId('id_don')
                    ->nullable()
                    ->after('id_demande')
                    ->constrained('dons')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('paiements', function (Blueprint $table) {
            $table->dropForeign(['id_don']);
            $table->dropColumn('id_don');
        });
    }
};