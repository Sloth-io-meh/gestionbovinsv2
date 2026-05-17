<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VisiteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('visites')->insert([
            [
                'id_pres' => 1,
                'description_v' => 'nfielkz',
                'datepres' => '2019-01-01',
                'prix_pres' => 500.99,
                'id_bov' => 4856,
                'id_vet' => 'EE796772',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
