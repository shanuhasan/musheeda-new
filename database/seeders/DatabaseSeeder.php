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
        User::updateOrCreate(
            ['email' => 'admin@musheeda.com'], // Replace with your desired admin email
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'), // Replace with a strong password
                'email_verified_at' => now(),
            ]
        );
    }
}
