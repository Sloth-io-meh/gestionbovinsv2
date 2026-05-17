<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuarantaineSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('quarantaines')->insert([
            ['id_q' => 1, 'libelle' => 'true', 'created_at' => now(), 'updated_at' => now()],
            ['id_q' => 2, 'libelle' => 'false', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
