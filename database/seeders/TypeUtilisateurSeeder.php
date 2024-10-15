<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeUtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('type_utilisateurs')->insert([
            ['lib_type_utilisateur' => 'ADMIN'],
            ['lib_type_utilisateur' => 'CURE'],
            ['lib_type_utilisateur' => 'RESPONSABLE MVT'],
            ['lib_type_utilisateur' => 'PRETRE'],
            ['lib_type_utilisateur' => 'PAROISSIEN'],
            ['lib_type_utilisateur' => 'SECRETAIRE'],
            ['lib_type_utilisateur' => 'NON PAROISSIEN'],
            ['lib_type_utilisateur' => 'RESPONSABLE CATECHESE'],
            ['lib_type_utilisateur' => 'VICE RESPO CONSEIL PAROISSIAL'],
        ]);
    }
}