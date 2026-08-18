<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_admin_can_view_tags()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        
        $response = $this->actingAs($admin)->get(route('admin.tags.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_tag()
    {
        $admin = User::factory()->create()->assignRole('Admin');

        $response = $this->actingAs($admin)->post(route('admin.tags.store'), [
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseHas('tags', [
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);
    }

    public function test_unauthorized_user_cannot_create_tag()
    {
        $user = User::factory()->create(); // No roles

        $response = $this->actingAs($user)->post(route('admin.tags.store'), [
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        $response->assertStatus(403);
    }

    public function test_tag_requires_name()
    {
        $admin = User::factory()->create()->assignRole('Admin');

        $response = $this->actingAs($admin)->post(route('admin.tags.store'), [
            // missing name
            'slug' => 'laravel',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_tag()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $tag = Tag::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $response = $this->actingAs($admin)->put(route('admin.tags.update', $tag), [
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);

        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);
    }

    public function test_admin_can_delete_tag()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $tag = Tag::create(['name' => 'To Delete', 'slug' => 'to-delete']);

        $response = $this->actingAs($admin)->delete(route('admin.tags.destroy', $tag));

        $response->assertRedirect(route('admin.tags.index'));
        $this->assertDatabaseMissing('tags', [
            'id' => $tag->id,
        ]);
    }
}
