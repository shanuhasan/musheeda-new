<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contracts\NewsletterServiceInterface;

class NewsletterController extends Controller
{
    protected $newsletter;

    public function __construct(NewsletterServiceInterface $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'website_url' => 'nullable|string', // Honeypot
        ]);

        if (!empty($request->website_url)) {
            // Spam detected, silently return success
            return back()->with('success', 'Thanks for subscribing!');
        }

        $data = [
            'source' => $request->input('source', url()->previous()),
            'ip_address' => $request->ip(),
        ];

        $this->newsletter->subscribe($request->email, $data);

        session()->flash('conversion', [
            'event' => 'sign_up',
            'data' => [
                'signup_type' => 'newsletter',
                'source' => $data['source'],
            ]
        ]);

        return back()->with('success', 'Thanks for subscribing! Please check your email to verify your subscription.');
    }

    public function verify($token)
    {
        if ($this->newsletter->verify($token)) {
            return redirect()->route('home')->with('success', 'Your newsletter subscription has been verified successfully!');
        }

        return redirect()->route('home')->with('error', 'Invalid or expired verification link.');
    }

    public function unsubscribe($token)
    {
        if ($this->newsletter->unsubscribeByToken($token)) {
            return redirect()->route('home')->with('success', 'You have successfully unsubscribed from our newsletter.');
        }

        return redirect()->route('home')->with('error', 'Invalid unsubscribe link.');
    }
}
