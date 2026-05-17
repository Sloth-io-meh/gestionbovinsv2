<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed the admin user from the original database
        // Original: password was '1234' (plain text)
        // Now hashed with bcrypt (12 rounds)
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Laakik Saad Eddine',
                'nom' => 'laakik',
                'prenom' => 'saad eddine',
                'adresse' => 'kennaria db el aarsa n35',
                'ville' => 'marrakech',
                'code' => '40040',
                'tel' => '0674276262',
                'email' => 'saadlk1997@gmail.com',
                'password' => Hash::make('1234'), // Hash the original password
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
