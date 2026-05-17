<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendeurSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('vendeurs')->insert([
            [
                'id_vend' => 1,
                'nom_vend' => 'laakik',
                'prenom_vend' => 'saad',
                'tel_vend' => '0674027761',
                'farm_vend' => "LAAKIK'S",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_vend' => 2,
                'nom_vend' => 'Laakik',
                'prenom_vend' => 'saad eddine',
                'tel_vend' => '0674272662',
                'farm_vend' => 'ManOhMan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_vend' => 3,
                'nom_vend' => 'Baha eddine',
                'prenom_vend' => 'Mouad',
                'tel_vend' => '212674561',
                'farm_vend' => 'Meh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
