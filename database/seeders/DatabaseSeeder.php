<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hanya memanggil seeder admin
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}