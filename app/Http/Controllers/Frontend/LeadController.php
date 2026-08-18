<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot spam protection
        if ($request->filled('website_url')) {
            return back()->with('success', 'Thank you for your submission.'); // Silently drop spam
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|required_without:phone',
            'phone' => 'nullable|string|max:50|required_without:email',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'source' => 'required|string|in:contact,product,service,landing,demo,quote',
            'landing_page' => 'nullable|string|max:255',
            'product_service' => 'nullable|string|max:255',
        ]);

        $lead = Lead::create(array_merge($validated, [
            'utm_source' => session('utm_source', $request->query('utm_source')),
            'utm_medium' => session('utm_medium', $request->query('utm_medium')),
            'utm_campaign' => session('utm_campaign', $request->query('utm_campaign')),
            'utm_term' => session('utm_term', $request->query('utm_term')),
            'utm_content' => session('utm_content', $request->query('utm_content')),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'new',
        ]));

        // Notify Admins
        $admins = User::role('Admin')->get(); // Assumes Spatie Permission is used
        Notification::send($admins, new NewLeadNotification($lead));

        session()->flash('conversion', [
            'event' => 'generate_lead',
            'data' => [
                'lead_source' => $lead->source,
                'lead_product' => $lead->product_service,
            ]
        ]);

        return back()->with('success', 'Thank you! We will get in touch with you shortly.');
    }
}
