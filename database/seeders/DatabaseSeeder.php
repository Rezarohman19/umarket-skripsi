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
        // User Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@umarket.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // User Pengguna 1
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@umarket.com',
            'password' => bcrypt('password123'),
            'role' => 'pengguna',
            'email_verified_at' => now(),
        ]);

        // User Pengguna 2
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@umarket.com',
            'password' => bcrypt('password123'),
            'role' => 'pengguna',
            'email_verified_at' => now(),
        ]);

        // User Pengguna 3
        User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@umarket.com',
            'password' => bcrypt('password123'),
            'role' => 'pengguna',
            'email_verified_at' => now(),
        ]);
    }
}
