<?php

namespace Tests\Feature;

use App\Models\MediaAsset;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
        Storage::fake('public');
    }

    public function test_admin_can_view_media_library()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        
        $response = $this->actingAs($admin)->get(route('admin.media.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_upload_permitted_media()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($admin)->post(route('admin.media.store'), [
            'file' => $file,
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseCount('media_assets', 1);
        $this->assertDatabaseCount('media', 1);
        
        $media = Media::first();
        $this->assertEquals('photo', $media->name);
        $this->assertStringContainsString('.jpg', $media->file_name);
    }

    public function test_admin_cannot_upload_svg_due_to_security_mitigation()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        $file = UploadedFile::fake()->create('vector.svg', 100, 'image/svg+xml');

        $response = $this->actingAs($admin)->post(route('admin.media.store'), [
            'file' => $file,
        ]);

        $response->assertSessionHasErrors('file');
        $this->assertDatabaseCount('media', 0);
    }

    public function test_unauthorized_user_cannot_upload_media()
    {
        $user = User::factory()->create(); // No role
        $file = UploadedFile::fake()->image('photo.jpg');

        $response = $this->actingAs($user)->post(route('admin.media.store'), [
            'file' => $file,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_media_custom_properties()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        
        $asset = MediaAsset::create(['uploaded_by' => $admin->id]);
        $media = $asset->addMedia(UploadedFile::fake()->image('test.jpg'))
            ->toMediaCollection('default');

        $response = $this->actingAs($admin)->put(route('admin.media.update', $media), [
            'name' => 'Updated Name',
            'custom_properties' => [
                'alt' => 'Alt text',
                'caption' => 'A caption',
            ]
        ]);

        $response->assertRedirect();
        
        $media->refresh();
        $this->assertEquals('Updated Name', $media->name);
        $this->assertEquals('Alt text', $media->getCustomProperty('alt'));
        $this->assertEquals('A caption', $media->getCustomProperty('caption'));
    }

    public function test_admin_can_delete_media()
    {
        $admin = User::factory()->create()->assignRole('Admin');
        
        $asset = MediaAsset::create(['uploaded_by' => $admin->id]);
        $media = $asset->addMedia(UploadedFile::fake()->image('test.jpg'))
            ->toMediaCollection('default');

        $response = $this->actingAs($admin)->delete(route('admin.media.destroy', $media));

        $response->assertRedirect();
        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }
}
