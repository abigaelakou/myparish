<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('source_id')->after('id');
            $table->string('source_type')->after('source_id');
        });

        // Modifications des colonnes existantes en SQL brut (évite doctrine/dbal)
        DB::statement("ALTER TABLE transactions MODIFY transaction_id VARCHAR(255) NULL");
        DB::statement("ALTER TABLE transactions MODIFY date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['source_id', 'source_type']);
        });

        // Optionnel: revenir en arrière sur les modifications SQL si besoin
        // DB::statement("ALTER TABLE transactions MODIFY transaction_id VARCHAR(255) NOT NULL");
        // DB::statement("ALTER TABLE transactions MODIFY date TIMESTAMP NULL");
    }
};
