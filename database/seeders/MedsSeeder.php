<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('meds')->insert([
            [
                'id_med' => 2,
                'libelle' => 'Ajaximusa',
                'description' => 'ajaximonoxile 500g 20 pellule more talk bla bla bla pfffff',
                'quantite_med' => 14,
                'prix_med' => 199.99,
                'dateachat' => '2015-03-13',
                'dateexp_med' => '2020-01-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
