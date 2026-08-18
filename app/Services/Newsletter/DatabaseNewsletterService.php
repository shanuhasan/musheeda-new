<?php

namespace App\Services\Newsletter;

use App\Contracts\NewsletterServiceInterface;
use App\Models\Subscriber;
use App\Notifications\VerifySubscriptionNotification;
use Illuminate\Support\Facades\Notification;

class DatabaseNewsletterService implements NewsletterServiceInterface
{
    public function subscribe(string $email, array $data = []): bool
    {
        $subscriber = Subscriber::withTrashed()->where('email', $email)->first();

        if ($subscriber) {
            if ($subscriber->trashed() || $subscriber->status === 'unsubscribed') {
                // Resubscribe
                $subscriber->restore();
                $subscriber->status = 'unverified';
                $subscriber->verified_at = null;
                $subscriber->unsubscribed_at = null;
                $subscriber->source = $data['source'] ?? $subscriber->source;
                $subscriber->ip_address = $data['ip_address'] ?? $subscriber->ip_address;
                $subscriber->generateToken();
                
                $subscriber->notify(new VerifySubscriptionNotification());
                return true;
            } elseif ($subscriber->status === 'unverified') {
                // Resend verification
                $subscriber->generateToken();
                $subscriber->notify(new VerifySubscriptionNotification());
                return true;
            }
            
            // Already subscribed and verified
            return true;
        }

        // New subscriber
        $subscriber = Subscriber::create([
            'email' => $email,
            'status' => 'unverified',
            'source' => $data['source'] ?? null,
            'ip_address' => $data['ip_address'] ?? null,
        ]);

        $subscriber->generateToken();
        $subscriber->notify(new VerifySubscriptionNotification());

        return true;
    }

    public function unsubscribe(string $email): bool
    {
        $subscriber = Subscriber::where('email', $email)->first();
        
        if ($subscriber) {
            $subscriber->update([
                'status' => 'unsubscribed',
                'unsubscribed_at' => now(),
            ]);
            return true;
        }
        
        return false;
    }

    public function verify(string $token): bool
    {
        $subscriber = Subscriber::where('token', $token)->where('status', 'unverified')->first();
        
        if ($subscriber) {
            $subscriber->update([
                'status' => 'subscribed',
                'verified_at' => now(),
                'token' => null, // clear token after use
            ]);
            return true;
        }
        
        return false;
    }

    public function unsubscribeByToken(string $token): bool
    {
        $subscriber = Subscriber::where('token', $token)->first();
        
        if ($subscriber) {
            $subscriber->update([
                'status' => 'unsubscribed',
                'unsubscribed_at' => now(),
                'token' => null,
            ]);
            return true;
        }
        
        return false;
    }
}
