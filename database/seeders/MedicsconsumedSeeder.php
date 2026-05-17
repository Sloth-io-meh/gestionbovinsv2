<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicsconsumedSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medicsconsumed')->insert([
            [
                'id_m' => 1,
                'libelle_m' => 'Ajaximusa',
                'quantite_m' => 1,
                'id_bov' => 485623,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_m' => 2,
                'libelle_m' => 'Ajaximusa',
                'quantite_m' => 1,
                'id_bov' => 123456789,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
