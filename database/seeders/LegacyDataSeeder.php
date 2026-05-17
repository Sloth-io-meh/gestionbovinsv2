<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LegacyDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $now = now();

        // Etables
        DB::table('etables')->insertOrIgnore([
            ['id_etab' => 3, 'nom' => 'Test2213', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Quarantaines
        DB::table('quarantaines')->insertOrIgnore([
            ['id_q' => 1, 'libelle' => 'true',  'created_at' => $now, 'updated_at' => $now],
            ['id_q' => 2, 'libelle' => 'false', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Vendeurs
        DB::table('vendeurs')->insertOrIgnore([
            ['id_vend' => 1, 'nom_vend' => 'laakik',      'prenom_vend' => 'saad',        'tel_vend' => '0674027761', 'farm_vend' => "LAAKIK'S",  'id_bov' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_vend' => 2, 'nom_vend' => 'Laakik',      'prenom_vend' => 'saad eddine', 'tel_vend' => '0674272662', 'farm_vend' => 'ManOhMan',  'id_bov' => null, 'created_at' => $now, 'updated_at' => $now],
            ['id_vend' => 3, 'nom_vend' => 'Baha eddine', 'prenom_vend' => 'Mouad',        'tel_vend' => '212674561',  'farm_vend' => 'Meh',       'id_bov' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Bovins (convert malformed dates, cast vendu/mort to bool)
        DB::table('bovins')->insertOrIgnore([
            ['id_bov' => 4856,      'race' => 'Meh Type Race etc....', 'dateachat' => '2019-03-07', 'prixachat' => 500.99, 'poidachat' => 35.5, 'lieuachat' => 'Marrakech bla bla', 'datevente' => '2019-03-14', 'prixavente' => 2500,   'poidvente' => 75,   'lieuvente' => 'sou9 blkjfeazblo',      'vendu' => 1, 'mort' => 0, 'datemort' => null,       'id_etab' => 3, 'id_vend' => 2, 'id_q' => 2, 'poidAct' => 76, 'created_at' => $now, 'updated_at' => $now],
            ['id_bov' => 74865,     'race' => 'test',                  'dateachat' => '1999-11-10', 'prixachat' => 250,    'poidachat' => 30,   'lieuachat' => 'kech',               'datevente' => '2019-03-15', 'prixavente' => 5000,   'poidvente' => 75,   'lieuvente' => 'kech',                  'vendu' => 1, 'mort' => 0, 'datemort' => null,       'id_etab' => 3, 'id_vend' => 2, 'id_q' => 2, 'poidAct' => 0,  'created_at' => $now, 'updated_at' => $now],
            ['id_bov' => 485623,    'race' => '3jel 1st Quality bla bla', 'dateachat' => '2019-03-15', 'prixachat' => 501, 'poidachat' => 35,   'lieuachat' => 'Marrakech 9le3t sraghna', 'datevente' => null,    'prixavente' => null,   'poidvente' => null, 'lieuvente' => null,                    'vendu' => 0, 'mort' => 0, 'datemort' => null,       'id_etab' => 3, 'id_vend' => 3, 'id_q' => 1, 'poidAct' => 0,  'created_at' => $now, 'updated_at' => $now],
            ['id_bov' => 1132456,   'race' => '3jel',                  'dateachat' => '2011-11-11', 'prixachat' => 500,    'poidachat' => 25,   'lieuachat' => 'Marrakech',          'datevente' => '2019-03-15', 'prixavente' => 2500,   'poidvente' => 75,   'lieuvente' => 'marrakech',             'vendu' => 0, 'mort' => 0, 'datemort' => null,       'id_etab' => 3, 'id_vend' => 1, 'id_q' => 2, 'poidAct' => 0,  'created_at' => $now, 'updated_at' => $now],
            ['id_bov' => 7846153,   'race' => 'testing',               'dateachat' => '1952-11-10', 'prixachat' => 500,    'poidachat' => 56,   'lieuachat' => 'kech',               'datevente' => '2019-05-15', 'prixavente' => 0,      'poidvente' => 0,    'lieuvente' => '',                      'vendu' => 0, 'mort' => 1, 'datemort' => '2019-03-15', 'id_etab' => 3, 'id_vend' => 1, 'id_q' => 2, 'poidAct' => 0,  'created_at' => $now, 'updated_at' => $now],
            ['id_bov' => 123456789, 'race' => '3jel',                  'dateachat' => '2019-03-15', 'prixachat' => 350.01, 'poidachat' => 50.5, 'lieuachat' => 'Marrakech - chi bled', 'datevente' => null,    'prixavente' => null,   'poidvente' => null, 'lieuvente' => null,                    'vendu' => 0, 'mort' => 0, 'datemort' => null,       'id_etab' => 3, 'id_vend' => 2, 'id_q' => 2, 'poidAct' => 0,  'created_at' => $now, 'updated_at' => $now],
        ]);

        // Stocks
        DB::table('stocks')->insertOrIgnore([
            ['id_stock' => 2, 'libelle_st' => 'fejzk', 'description_s' => 'nkflez', 'quantite_s' => 31, 'quantiteAct' => 14, 'prix_s' => 500, 'dateachat' => '2019-01-02', 'dateexp_s' => '2021-01-02', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Meds
        DB::table('meds')->insertOrIgnore([
            ['id_med' => 2, 'libelle' => 'Ajaximusa', 'description' => 'ajaximonoxile 500g 20 pellule, more talk bla bla bla pfffff', 'quantite_med' => 14, 'prix_med' => 199.99, 'dateachat' => '2015-03-13', 'dateexp_med' => '2020-01-01', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Tansporteurs
        DB::table('tansporteurs')->insertOrIgnore([
            ['id_trans' => 1, 'cin_t' => 'EE79677',  'nom' => 'laakika',     'prenom' => 'saad eddin', 'tel' => '067427626',   'created_at' => $now, 'updated_at' => $now],
            ['id_trans' => 2, 'cin_t' => 'EE9546',   'nom' => 'Baha-eddine', 'prenom' => 'Mouad',      'tel' => '06745216845', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Vehicules
        DB::table('vehicules')->insertOrIgnore([
            ['id_veh' => 6, 'Matricule' => '1151352-A-24', 'type' => '4x4',          'id_trans' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id_veh' => 8, 'Matricule' => '1423-A-26',    'type' => 'ford Transit',  'id_trans' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Vetos
        DB::table('vetos')->insertOrIgnore([
            ['id_vet' => 'EE123456', 'nom_vet' => 'Bahaeddine', 'prenom_vet' => 'Mouad',       'tel_vet' => '066664857', 'created_at' => $now, 'updated_at' => $now],
            ['id_vet' => 'EE796772', 'nom_vet' => 'Laakik',     'prenom_vet' => 'saad eddine', 'tel_vet' => '0674276262', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Visites
        DB::table('visites')->insertOrIgnore([
            ['id_pres' => 1, 'description_v' => 'nfielkz', 'datepres' => '2019-01-01', 'prix_pres' => 500.99, 'id_bov' => 4856, 'id_vet' => 'EE796772', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Admin user (you — saad eddine laakik)
        DB::table('users')->insertOrIgnore([
            ['id' => 1, 'name' => 'Saad Eddine Laakik', 'email' => 'saadlk1997@gmail.com', 'password' => Hash::make('password'), 'is_admin' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
