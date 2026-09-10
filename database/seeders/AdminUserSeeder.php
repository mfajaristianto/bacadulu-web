<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = strtolower(
            trim((string) config('services.admin_auth.email'))
        );

        if ($adminEmail === '') {
            $this->command?->warn(
                'ADMIN_AUTH_EMAIL belum dikonfigurasi. AdminUserSeeder dilewati.'
            );

            return;
        }

        $user = User::query()->firstOrNew([
            'email' => $adminEmail,
        ]);

        $user->forceFill([
            'name' => $user->name ?: 'Admin Utama',
            'password' => $user->password ?: Hash::make('bacaduluadmin'),
            'is_admin' => true,
            'email_verified_at' => $user->email_verified_at ?: now(),
        ]);

        $user->save();
    }
}
