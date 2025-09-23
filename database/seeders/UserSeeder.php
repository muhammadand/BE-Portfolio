<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Muhammad Andi (Admin)
        User::create([
            'name' => 'Muhammad Andi',
            'email' => 'muhammad.andi@gmail.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Rachmat (Support)
        User::create([
            'name' => 'Rachmat',
            'email' => 'rachmat@gmail.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        // Belva (Finance)
        User::create([
            'name' => 'Belva',
            'email' => 'belva@gmail.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
    }
}
