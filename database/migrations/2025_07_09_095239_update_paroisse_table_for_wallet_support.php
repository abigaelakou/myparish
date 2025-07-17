<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('paroisses', function (Blueprint $table) {
            $table->string('wallet_type')->nullable();
            $table->string('wallet_contact')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->string('payment_provider_url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('paroisses', function (Blueprint $table) {
            $table->dropColumn([
                'wallet_type',
                'wallet_contact',
                'api_key',
                'api_secret',
                'payment_provider_url',
            ]);
        });
    }
};
