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
            ['email' => 'adminbacadulu@gmail.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('bacaduluadmin'),
                'is_admin' => true,
            ]
        );
    }
}