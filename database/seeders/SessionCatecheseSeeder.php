<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SessionCatecheseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('session_catecheses')->insert([
            ['lib_session_catechese' => 'Session Enfant'],
            ['lib_session_catechese' => 'Session Jeune'],
            ['lib_session_catechese' => 'Session Adulte'],
        ]);
    }
}
