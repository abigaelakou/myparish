<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dons', function (Blueprint $table) {
            $table->boolean('anonyme')->default(false)->after('montant');
        });

        // Modifications en SQL brut (évite doctrine/dbal)
        DB::statement("ALTER TABLE dons MODIFY montant DECIMAL(12, 2) NOT NULL");
        DB::statement("ALTER TABLE dons MODIFY type_donateur ENUM('utilisateur', 'autre') NULL");
        DB::statement("ALTER TABLE dons MODIFY donateur_id BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE dons MODIFY contact VARCHAR(255) NULL");
    }

    public function down()
    {
        Schema::table('dons', function (Blueprint $table) {
            $table->dropColumn('anonyme');
        });

        // Optionnel: revert modifications SQL si tu veux (adapter selon l’état précédent)
        // DB::statement("ALTER TABLE dons MODIFY montant DECIMAL(10, 2) NOT NULL");
        // DB::statement("ALTER TABLE dons MODIFY type_donateur ENUM(...) NOT NULL");
        // DB::statement("ALTER TABLE dons MODIFY donateur_id BIGINT UNSIGNED NOT NULL");
        // DB::statement("ALTER TABLE dons MODIFY contact VARCHAR(255) NOT NULL");
    }
};
