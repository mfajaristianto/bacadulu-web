<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bacadulu.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );
    }
}