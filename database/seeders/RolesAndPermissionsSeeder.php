<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'view_users', 'create_users', 'update_users', 'delete_users',
            'manage_pages', 'manage_blogs', 'manage_media', 'manage_seo',
            'manage_settings', 'manage_products', 'manage_leads'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and assign created permissions

        // Super Admin gets all permissions via Gate::before in AppServiceProvider

        Role::create(['name' => 'Super Admin']);

        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());

        $editor = Role::create(['name' => 'Editor']);
        $editor->givePermissionTo(['manage_pages', 'manage_blogs', 'manage_media']);

        $author = Role::create(['name' => 'Author']);
        $author->givePermissionTo(['manage_blogs']);

        $seoManager = Role::create(['name' => 'SEO Manager']);
        $seoManager->givePermissionTo(['manage_seo']);
    }
}
