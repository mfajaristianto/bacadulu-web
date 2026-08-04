<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan baris ini

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat akun admin utama untuk semua device/tim
        User::updateOrCreate(
            ['email' => 'admin@bacadulu.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );

        // (Opsional) Jika ingin tetap membuat user test bawaan Laravel, biarkan baris di bawah aktif:
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}