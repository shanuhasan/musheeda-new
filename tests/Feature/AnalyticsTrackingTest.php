<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnalyticsTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_site_verification_renders(): void
    {
        Setting::create(['group' => 'integrations', 'key' => 'google_site_verification', 'value' => 'my-verification-code', 'type' => 'text']);

        $view = $this->blade('<x-tracking-scripts />');

        $view->assertSee('<meta name="google-site-verification" content="my-verification-code" />', false);
    }

    public function test_consent_mode_defaults_to_denied_when_enabled(): void
    {
        Setting::create(['group' => 'integrations', 'key' => 'google_analytics_id', 'value' => 'G-12345', 'type' => 'text']);
        Setting::create(['group' => 'integrations', 'key' => 'cookie_consent_enabled', 'value' => '1', 'type' => 'text']);

        $view = $this->blade('<x-tracking-scripts />');

        $view->assertSee("'ad_storage': 'denied'", false);
    }

    public function test_conversion_event_is_rendered_from_session(): void
    {
        Setting::create(['group' => 'integrations', 'key' => 'google_analytics_id', 'value' => 'G-12345', 'type' => 'text']);
        
        session()->flash('conversion', [
            'event' => 'generate_lead',
            'data' => ['lead_source' => 'contact']
        ]);

        $view = $this->blade('<x-tracking-scripts />');

        $view->assertSee("gtag('event', 'generate_lead'", false);
        $view->assertSee('"lead_source":"contact"', false);
    }
}
