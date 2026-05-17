<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NourritureSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nourriture')->insert([
            ['id_n' => 2, 'libelle_n' => 'ngkle', 'quantite_n' => '1', 'id_bov' => 123456789, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 3, 'libelle_n' => 'fejzk', 'quantite_n' => '1', 'id_bov' => 1132456, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 4, 'libelle_n' => 'fejzk', 'quantite_n' => '1', 'id_bov' => 485623, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 5, 'libelle_n' => 'fejzk', 'quantite_n' => '1', 'id_bov' => 485623, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 6, 'libelle_n' => 'fejzk', 'quantite_n' => '1', 'id_bov' => 485623, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 7, 'libelle_n' => 'fejzk', 'quantite_n' => '6', 'id_bov' => 1132456, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 8, 'libelle_n' => 'fejzk', 'quantite_n' => '2', 'id_bov' => 485623, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 9, 'libelle_n' => 'fejzk', 'quantite_n' => '2', 'id_bov' => 1132456, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 10, 'libelle_n' => 'fejzk', 'quantite_n' => '2', 'id_bov' => 123456789, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 11, 'libelle_n' => 'fejzk', 'quantite_n' => '2', 'id_bov' => 485623, 'created_at' => now(), 'updated_at' => now()],
            ['id_n' => 12, 'libelle_n' => 'fejzk', 'quantite_n' => '2', 'id_bov' => 485623, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
