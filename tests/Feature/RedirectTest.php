<?php

namespace Tests\Feature;

use App\Models\Redirect;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_admin_can_view_redirects()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        
        $response = $this->actingAs($admin)->get(route('admin.redirects.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_redirect()
    {
        $admin = User::factory()->create()->assignRole('Admin');

        $response = $this->actingAs($admin)->post(route('admin.redirects.store'), [
            'old_url' => '/old-page',
            'new_url' => '/new-page',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.redirects.index'));
        $this->assertDatabaseHas('redirects', [
            'old_url' => 'old-page',
            'new_url' => 'new-page',
            'status_code' => 301,
        ]);
    }

    public function test_redirect_manager_intercepts_and_redirects()
    {
        Redirect::create([
            'old_url' => '/missing-page',
            'new_url' => '/found-page',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $response = $this->get('/missing-page');
        $response->assertStatus(301);
        $response->assertRedirect('/found-page');
    }

    public function test_inactive_redirect_is_ignored()
    {
        Redirect::create([
            'old_url' => '/old-page',
            'new_url' => '/new-page',
            'status_code' => 301,
            'is_active' => false,
        ]);

        $response = $this->get('/old-page');
        // Since there is no actual page for /old-page, it should fallback to dynamic page router
        // and either 404 or redirect. Since we want to prove it's NOT a 301 to /new-page, we assert it doesn't redirect there.
        $this->assertTrue($response->status() !== 301 || $response->headers->get('Location') !== url('/new-page'));
    }

    public function test_unauthorized_user_cannot_manage_redirects()
    {
        $user = User::factory()->create(); // No roles

        $response = $this->actingAs($user)->post(route('admin.redirects.store'), [
            'old_url' => '/old',
            'new_url' => '/new',
            'status_code' => 301,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_redirect()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $redirect = Redirect::create([
            'old_url' => '/old-page',
            'new_url' => '/new-page',
            'status_code' => 301,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.redirects.update', $redirect), [
            'old_url' => '/old-page',
            'new_url' => '/newer-page',
            'status_code' => 302,
        ]);

        $response->assertRedirect(route('admin.redirects.index'));
        $this->assertDatabaseHas('redirects', [
            'id' => $redirect->id,
            'new_url' => 'newer-page',
            'status_code' => 302,
            'is_active' => false,
        ]);
    }

    public function test_admin_can_delete_redirect()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $redirect = Redirect::create([
            'old_url' => '/old',
            'new_url' => '/new',
            'status_code' => 301,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.redirects.destroy', $redirect));

        $response->assertRedirect(route('admin.redirects.index'));
        $this->assertDatabaseMissing('redirects', [
            'id' => $redirect->id,
        ]);
    }
}
