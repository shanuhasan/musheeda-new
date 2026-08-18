<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Optional filtering by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Optional filtering by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->paginate(50)->withQueryString();

        $actions = ActivityLog::select('action')->distinct()->pluck('action');
        $users = \App\Models\User::has('activityLogs')->get(['id', 'name']);

        return view('admin.activity-logs.index', compact('logs', 'actions', 'users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityLog $activityLog)
    {
        $activityLog->load('user');
        return view('admin.activity-logs.show', compact('activityLog'));
    }
}
