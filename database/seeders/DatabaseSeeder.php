<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call seeders in order of dependencies
        $this->call([
            QuarantaineSeeder::class,  // Lookup table first
            UserSeeder::class,         // Users
            EtableSeeder::class,       // Farms
            VendeurSeeder::class,      // Sellers
            BovinSeeder::class,        // Cattle
            StockSeeder::class,        // Feed inventory
            MedsSeeder::class,         // Medicines
            MedicsconsumedSeeder::class, // Medicine logs
            NourritureSeeder::class,   // Feeding logs
            TansporteurSeeder::class,  // Transporters
            VehiculeSeeder::class,     // Vehicles
            VetoSeeder::class,         // Veterinarians
            VisiteSeeder::class,       // Vet visits
        ]);
    }
}
