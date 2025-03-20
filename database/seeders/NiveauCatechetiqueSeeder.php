<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NiveauCatechetiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('niveau_catechetiques')->insert([
            ['lib_niveau' => '1ère Année'],
            ['lib_niveau' => '2ème Année'],
            ['lib_niveau' => '3ème Année'],
            ['lib_niveau' => '4ème Année'],
            ['lib_niveau' => '5ème Année'],
        ]);
    }
}