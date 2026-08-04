<?php

namespace Tests\Feature;

use App\Models\Information;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_view_dashboard(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_non_admin_cannot_access_dashboard(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $this->actingAs($user);

        $response = $this->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_can_create_information(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $this->actingAs($admin);

        $response = $this->post('/admin/informations', [
            'title' => 'Test Informasi',
            'content' => 'Isi konten test',
            'image' => '',
        ]);

        $response->assertRedirect('/admin/informations');
        $this->assertDatabaseHas('informations', [
            'title' => 'Test Informasi',
            'content' => 'Isi konten test',
        ]);
    }
}
