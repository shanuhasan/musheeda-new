<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolesAndPermissionsSeeder;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_admin_can_view_dashboard()
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
        $response->assertViewHas('metrics');
        $response->assertViewHas('recent');
    }

    public function test_unauthorized_user_cannot_view_dashboard()
    {
        $user = User::factory()->create(); // No role

        $response = $this->actingAs($user)->get(route('admin.dashboard'));
        
        $response->assertStatus(403);
    }
}
