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
    Schema::table('paroisses', function (Blueprint $table) {
        $table->unsignedBigInteger('diocese_id')->nullable()->after('id');

        $table->foreign('diocese_id')
            ->references('id')->on('dioceses')
            ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('paroisses', function (Blueprint $table) {
        $table->dropForeign(['diocese_id']);
        $table->dropColumn('diocese_id');
    });
}

};