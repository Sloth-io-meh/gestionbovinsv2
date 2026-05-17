<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehiculeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vehicules')->insert([
            [
                'id_veh' => 6,
                'Matricule' => '1151352-A-24',
                'type' => '4x4',
                'id_trans' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_veh' => 8,
                'Matricule' => '1423-A-26',
                'type' => 'ford Transit',
                'id_trans' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
