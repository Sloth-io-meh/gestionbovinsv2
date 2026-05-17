<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stocks')->insert([
            [
                'id_stock' => 2,
                'libelle_st' => 'fejzk',
                'description_s' => 'nkflez',
                'quantite_s' => 31,
                'quantiteAct' => 14,
                'prix_s' => 500,
                'dateachat' => '2019-01-02',
                'dateexp_s' => '2021-01-02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
