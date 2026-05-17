<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('etables')->insert([
            [
                'id_etab' => 3,
                'nom' => 'Test2213',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
