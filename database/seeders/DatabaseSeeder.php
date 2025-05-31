<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun Login
        User::create([
            'name' => 'Ifa',
            'email' => 'ifa@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
