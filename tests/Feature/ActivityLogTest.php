<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_user_login_and_logout()
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'login',
        ]);

        $this->post('/logout');

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->id,
            'action' => 'logout',
        ]);
    }

    public function test_it_logs_model_creation_and_updates()
    {
        // Activity logger will skip logging if running in console (unless tests).
        // Our observer says: `if (app()->runningInConsole() && !app()->runningUnitTests()) { return; }`
        // Wait, tests run in console, so `app()->runningInConsole()` is true, and `app()->runningUnitTests()` is true.
        // Let's create a model that is observed. Setting is observed.

        $setting = Setting::create([
            'group' => 'general',
            'key' => 'site_name',
            'value' => 'My Site',
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'create',
            'model_type' => Setting::class,
            'model_id' => $setting->id,
        ]);

        $setting->update(['value' => 'New Site Name']);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'update',
            'model_type' => Setting::class,
            'model_id' => $setting->id,
        ]);
    }

    public function test_it_scrubs_sensitive_metadata()
    {
        $logger = app(\App\Services\ActivityLogger::class);

        $log = $logger->log('custom_action', null, [
            'email' => 'test@example.com',
            'password' => 'secret123',
            'nested' => [
                'token' => 'abcxyz',
                'public_data' => 'hello',
            ]
        ]);

        $metadata = $log->metadata;

        $this->assertEquals('test@example.com', $metadata['email']);
        $this->assertEquals('********', $metadata['password']);
        $this->assertEquals('********', $metadata['nested']['token']);
        $this->assertEquals('hello', $metadata['nested']['public_data']);
    }

    public function test_admin_can_view_activity_logs()
    {
        $admin = User::factory()->create();
        $role = Role::create(['name' => 'Super Admin']);
        $admin->assignRole($role);

        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'test_action',
            'description' => 'Test Description',
        ]);

        $response = $this->actingAs($admin)->get('/admin/activity-logs');

        $response->assertStatus(200);
        $response->assertSee('test_action');
        $response->assertSee('Test Description');
    }

    public function test_old_logs_are_pruned()
    {
        // Create an old log (40 days old)
        \Illuminate\Support\Facades\DB::table('activity_logs')->insert([
            'action' => 'old_action',
            'created_at' => now()->subDays(40),
            'updated_at' => now()->subDays(40),
        ]);

        // Create a recent log (10 days old)
        \Illuminate\Support\Facades\DB::table('activity_logs')->insert([
            'action' => 'recent_action',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        $this->assertDatabaseCount('activity_logs', 2);

        Artisan::call('logs:prune', ['--days' => 30]);

        $this->assertDatabaseCount('activity_logs', 1);
        $this->assertDatabaseMissing('activity_logs', ['action' => 'old_action']);
        $this->assertDatabaseHas('activity_logs', ['action' => 'recent_action']);
    }
}
