<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('expo_token')->nullable();
            $table->integer('last_pain_id')->nullable()->after('expo_token');
            $table->integer('last_annonce_id')->nullable()->after('last_pain_id');
            $table->integer('last_evenement_id')->nullable()->after('last_annonce_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['last_pain_id', 'last_annonce_id', 'last_evenement_id']);
        });
    }
};