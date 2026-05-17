<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TansporteurSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tansporteurs')->insert([
            [
                'id_trans' => 1,
                'cin_t' => '   EE79677',
                'nom' => '   laakika  ',
                'prenom' => '   saad eddin',
                'tel' => '067427626',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_trans' => 2,
                'cin_t' => 'EE9546',
                'nom' => 'Baha-eddine',
                'prenom' => 'Mouad',
                'tel' => '06745216845',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
