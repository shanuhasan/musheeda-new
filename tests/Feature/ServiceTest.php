<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $role = Role::create(['name' => 'Super Admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    public function test_admin_can_create_service()
    {
        $response = $this->actingAs($this->admin)->post('/admin/services', [
            'name' => 'Custom Software',
            'slug' => 'custom-software',
            'status' => 'active',
            'sort_order' => 1,
            'features' => ['Fast', 'Scalable']
        ]);

        $response->assertRedirect('/admin/services');
        
        $this->assertDatabaseHas('services', [
            'name' => 'Custom Software',
            'slug' => 'custom-software'
        ]);
        
        $service = Service::first();
        $this->assertEquals(['Fast', 'Scalable'], $service->features);
    }

    public function test_public_can_view_active_services()
    {
        $service = Service::factory()->create(['status' => 'active']);
        
        $response = $this->get('/services');
        $response->assertStatus(200);
        $response->assertSee($service->name);

        $response = $this->get('/services/' . $service->slug);
        $response->assertStatus(200);
        $response->assertSee($service->name);
    }

    public function test_public_cannot_view_inactive_services()
    {
        $service = Service::factory()->create(['status' => 'inactive']);
        
        $response = $this->get('/services/' . $service->slug);
        $response->assertStatus(404);
    }
}
