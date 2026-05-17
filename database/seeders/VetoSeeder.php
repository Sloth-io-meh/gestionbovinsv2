<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VetoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vetos')->insert([
            [
                'id_vet' => 'EE123456',
                'nom_vet' => '  Bahaeddine  ',
                'prenom_vet' => ' Mouad',
                'tel_vet' => '  066664857',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_vet' => 'EE796772',
                'nom_vet' => 'Laakik',
                'prenom_vet' => 'saad eddine',
                'tel_vet' => '0674276262',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
