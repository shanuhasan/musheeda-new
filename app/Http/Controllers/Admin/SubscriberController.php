<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscriber::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subscribers = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function export(Request $request)
    {
        $query = Subscriber::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subscribers = $query->orderBy('created_at', 'desc')->get();

        $csvFileName = 'subscribers-' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $handle = fopen('php://output', 'w');
        
        ob_start();
        fputcsv($handle, ['Email', 'Status', 'Source', 'IP Address', 'Verified At', 'Unsubscribed At', 'Subscribed At']);

        foreach ($subscribers as $subscriber) {
            fputcsv($handle, [
                $subscriber->email,
                $subscriber->status,
                $subscriber->source,
                $subscriber->ip_address,
                $subscriber->verified_at ? $subscriber->verified_at->format('Y-m-d H:i:s') : '',
                $subscriber->unsubscribed_at ? $subscriber->unsubscribed_at->format('Y-m-d H:i:s') : '',
                $subscriber->created_at->format('Y-m-d H:i:s'),
            ]);
        }
        fclose($handle);
        $csvContent = ob_get_clean();

        return response($csvContent, 200, $headers);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber deleted successfully.');
    }
}
