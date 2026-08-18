<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Lead;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewLeadNotification;

class LeadTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_submit_lead()
    {
        Notification::fake();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $admin = \App\Models\User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->post(route('leads.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'source' => 'contact',
            'message' => 'Hello there',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('leads', [
            'email' => 'john@example.com'
        ]);

        Notification::assertSentTo(
            \App\Models\User::role('Admin')->get(),
            NewLeadNotification::class
        );
    }

    public function test_honeypot_blocks_spam()
    {
        $response = $this->post(route('leads.store'), [
            'name' => 'Spammer',
            'email' => 'spam@example.com',
            'source' => 'contact',
            'website_url' => 'http://spam.com', // Honeypot filled
        ]);

        $response->assertStatus(302);
        
        $this->assertDatabaseMissing('leads', [
            'email' => 'spam@example.com'
        ]);
    }
}
