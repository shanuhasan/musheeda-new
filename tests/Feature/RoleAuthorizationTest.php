<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\RolesAndPermissionsSeeder;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_editor_can_manage_pages()
    {
        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        $this->assertTrue($editor->can('create', Page::class));
    }

    public function test_author_cannot_manage_pages()
    {
        $author = User::factory()->create();
        $author->assignRole('Author');

        $this->assertFalse($author->can('create', Page::class));
    }

    public function test_super_admin_can_manage_everything()
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('Super Admin');

        $this->assertTrue($superAdmin->can('update', new Setting()));
        $this->assertTrue($superAdmin->can('delete', new Page()));
        $this->assertTrue($superAdmin->can('create', new User()));
    }
}
