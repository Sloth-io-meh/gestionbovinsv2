<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /*
     * Seeded credentials
     * ─────────────────────────────────────────────
     * ADMINS
     *   saadlk1997@gmail.com   password: Admin@2026
     *   a.benali@farm.ma       password: Admin@2026
     *   f.zahra@farm.ma        password: Admin@2026
     *
     * ADMINS (additional)
     *   y.alaoui@farm.ma       password: User@2026
     *   k.bennani@farm.ma      password: User@2026
     *   o.tazi@farm.ma         password: User@2026
     *   n.chraibi@farm.ma      password: User@2026
     * ─────────────────────────────────────────────
     */
    public function run(): void
    {
        $adminPassword = Hash::make('Admin@2026');
        $userPassword  = Hash::make('User@2026');
        $now           = now();

        DB::table('users')->upsert(
            [
                // ── Admins ──────────────────────────────────────────────
                [
                    'name'               => 'Saad Eddine Laakik',
                    'nom'                => 'Laakik',
                    'prenom'             => 'Saad Eddine',
                    'email'              => 'saadlk1997@gmail.com',
                    'password'           => $adminPassword,
                    'is_admin'           => true,
                    'adresse'            => 'Kennaria DB El Aarsa N35',
                    'ville'              => 'Marrakech',
                    'code'               => '40040',
                    'tel'                => '0674276262',
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ],
                [
                    'name'               => 'Ahmed Benali',
                    'nom'                => 'Benali',
                    'prenom'             => 'Ahmed',
                    'email'              => 'a.benali@farm.ma',
                    'password'           => $adminPassword,
                    'is_admin'           => true,
                    'adresse'            => '12 Rue Hassan II',
                    'ville'              => 'Casablanca',
                    'code'               => '20000',
                    'tel'                => '0661234567',
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ],
                [
                    'name'               => 'Fatima Zahra Idrissi',
                    'nom'                => 'Idrissi',
                    'prenom'             => 'Fatima Zahra',
                    'email'              => 'f.zahra@farm.ma',
                    'password'           => $adminPassword,
                    'is_admin'           => true,
                    'adresse'            => '5 Avenue Mohammed V',
                    'ville'              => 'Rabat',
                    'code'               => '10000',
                    'tel'                => '0662345678',
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ],

                // ── Regular users ────────────────────────────────────────
                [
                    'name'               => 'Youssef Alaoui',
                    'nom'                => 'Alaoui',
                    'prenom'             => 'Youssef',
                    'email'              => 'y.alaoui@farm.ma',
                    'password'           => $userPassword,
                    'is_admin'           => true,
                    'adresse'            => '8 Rue Ibn Battouta',
                    'ville'              => 'Fès',
                    'code'               => '30000',
                    'tel'                => '0663456789',
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ],
                [
                    'name'               => 'Khadija Bennani',
                    'nom'                => 'Bennani',
                    'prenom'             => 'Khadija',
                    'email'              => 'k.bennani@farm.ma',
                    'password'           => $userPassword,
                    'is_admin'           => true,
                    'adresse'            => '22 Boulevard Zerktouni',
                    'ville'              => 'Meknès',
                    'code'               => '50000',
                    'tel'                => '0664567890',
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ],
                [
                    'name'               => 'Omar Tazi',
                    'nom'                => 'Tazi',
                    'prenom'             => 'Omar',
                    'email'              => 'o.tazi@farm.ma',
                    'password'           => $userPassword,
                    'is_admin'           => true,
                    'adresse'            => '3 Derb Soltane',
                    'ville'              => 'Marrakech',
                    'code'               => '40000',
                    'tel'                => '0665678901',
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ],
                [
                    'name'               => 'Nadia Chraibi',
                    'nom'                => 'Chraibi',
                    'prenom'             => 'Nadia',
                    'email'              => 'n.chraibi@farm.ma',
                    'password'           => $userPassword,
                    'is_admin'           => true,
                    'adresse'            => '17 Rue Al Qods',
                    'ville'              => 'Agadir',
                    'code'               => '80000',
                    'tel'                => '0666789012',
                    'email_verified_at'  => $now,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ],
            ],
            ['email'],
            ['name', 'nom', 'prenom', 'password', 'is_admin', 'adresse', 'ville', 'code', 'tel', 'email_verified_at', 'updated_at']
        );
    }
}
