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
        $table->unsignedBigInteger('paroisse_id')->nullable()->after('contact');
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
            //
              Schema::table('paiements', function (Blueprint $table) {
        $table->dropColumn('paroisse_id');
    });
        });
    }
};
