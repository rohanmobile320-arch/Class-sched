<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@classschedule.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Student users
        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@student.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane.smith@student.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Bob Johnson',
            'email' => 'bob.johnson@student.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'is_active' => true,
        ]);
    }
}
