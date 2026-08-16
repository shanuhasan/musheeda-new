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
            Permission::findOrCreate($permission, 'web');
        }

        // Create Roles and assign created permissions

        // Super Admin gets all permissions via Gate::before in AppServiceProvider

        $superAdmin = Role::findOrCreate('Super Admin', 'web');

        $admin = Role::findOrCreate('Admin', 'web');
        $admin->givePermissionTo(Permission::all());

        $editor = Role::findOrCreate('Editor', 'web');
        $editor->givePermissionTo(['manage_pages', 'manage_blogs', 'manage_media']);

        $author = Role::findOrCreate('Author', 'web');
        $author->givePermissionTo(['manage_blogs']);

        $seoManager = Role::findOrCreate('SEO Manager', 'web');
        $seoManager->givePermissionTo(['manage_seo']);
    }
}
