<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Anonyme',
            'email' => 'anonyme@exemple.com',
            'contact' => '0100000000',
            'password' => bcrypt('anonyme'),
            'status' => 1, // Si tu as une colonne de statut, ajuste-la
            'id_type_utilisateur' => 1 // Type d'utilisateur correspondant, si tu as cette colonne
        ]);
    }
}
