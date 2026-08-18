<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_admin_can_view_categories()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        
        $response = $this->actingAs($admin)->get(route('admin.categories.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_category()
    {
        $admin = User::factory()->create()->assignRole('Admin');

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Technology',
            'slug' => 'technology',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Technology',
            'slug' => 'technology',
        ]);
    }

    public function test_unauthorized_user_cannot_create_category()
    {
        $user = User::factory()->create(); // No roles

        $response = $this->actingAs($user)->post(route('admin.categories.store'), [
            'name' => 'Technology',
            'slug' => 'technology',
        ]);

        $response->assertStatus(403);
    }

    public function test_category_requires_name()
    {
        $admin = User::factory()->create()->assignRole('Admin');

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            // missing name
            'slug' => 'technology',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_category()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $category = Category::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $response = $this->actingAs($admin)->put(route('admin.categories.update', $category), [
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);
    }

    public function test_admin_can_delete_category()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $category = Category::create(['name' => 'To Delete', 'slug' => 'to-delete']);

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }
}
