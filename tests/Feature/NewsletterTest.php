<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use App\Notifications\VerifySubscriptionNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_subscribe_to_newsletter()
    {
        Notification::fake();

        $response = $this->post(route('newsletter.subscribe'), [
            'email' => 'test@example.com',
            'source' => 'test',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('subscribers', [
            'email' => 'test@example.com',
            'status' => 'unverified',
        ]);

        $subscriber = Subscriber::where('email', 'test@example.com')->first();

        Notification::assertSentTo(
            $subscriber,
            VerifySubscriptionNotification::class
        );
    }

    public function test_honeypot_blocks_spam()
    {
        Notification::fake();

        $response = $this->post(route('newsletter.subscribe'), [
            'email' => 'spam@example.com',
            'website_url' => 'http://spam.com',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('subscribers', [
            'email' => 'spam@example.com',
        ]);

        Notification::assertNothingSent();
    }

    public function test_can_verify_subscription()
    {
        $subscriber = Subscriber::create([
            'email' => 'test@example.com',
            'status' => 'unverified',
        ]);
        $token = $subscriber->generateToken();

        $response = $this->get(route('newsletter.verify', $token));

        $response->assertStatus(302);
        
        $this->assertDatabaseHas('subscribers', [
            'email' => 'test@example.com',
            'status' => 'subscribed',
        ]);
    }
}
