<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (Storage::directories('users') as $path) {
            Storage::deleteDirectory($path);
        }

        $this->call([
            RoleSeeder::class,
            AreaSeeder::class,
            StationSeeder::class,
            UserSeeder::class,
            ReservationStatusSeeder::class
        ]);
    }
}
