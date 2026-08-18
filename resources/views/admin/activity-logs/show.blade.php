@extends('layouts.admin')

@section('title', 'Activity Log Details')
@section('header', 'Activity Log Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.activity-logs.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-800 dark:text-brand-400 dark:hover:text-brand-300 flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Activity Logs
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Log Details -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Summary</h3>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Action</dt>
                        <dd class="mt-1 text-lg font-bold text-slate-900 dark:text-white capitalize">{{ $activityLog->action }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Date & Time</dt>
                        <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $activityLog->created_at->format('F d, Y - H:i:s') }} ({{ $activityLog->created_at->diffForHumans() }})</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">User</dt>
                        <dd class="mt-1 text-sm text-slate-900 dark:text-white">
                            @if($activityLog->user)
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs">
                                        {{ substr($activityLog->user->name, 0, 1) }}
                                    </div>
                                    {{ $activityLog->user->name }} <span class="text-slate-500">({{ $activityLog->user->email }})</span>
                                </div>
                            @else
                                <span class="italic text-slate-500">System / Guest</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">IP Address</dt>
                        <dd class="mt-1 text-sm font-mono text-slate-900 dark:text-white">{{ $activityLog->ip_address ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        @if($activityLog->model_type)
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Subject</h3>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Model</dt>
                        <dd class="mt-1 text-sm font-mono text-slate-900 dark:text-white">{{ $activityLog->model_type }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">ID</dt>
                        <dd class="mt-1 text-sm font-mono text-slate-900 dark:text-white">{{ $activityLog->model_id ?? 'N/A' }}</dd>
                    </div>
                    @if($activityLog->description)
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Description</dt>
                        <dd class="mt-1 text-sm text-slate-900 dark:text-white font-medium">{{ $activityLog->description }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
        @endif
    </div>

    <!-- Metadata / Payload -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden h-full">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Payload & Metadata</h3>
            </div>
            <div class="p-0 bg-slate-900">
                @if(!empty($activityLog->metadata))
                    <pre class="p-6 text-sm text-green-400 overflow-x-auto font-mono leading-relaxed" style="tab-size: 4;"><code>{{ json_encode($activityLog->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</code></pre>
                @else
                    <div class="p-12 text-center text-slate-500">
                        <svg class="mx-auto h-12 w-12 text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        <p>No additional metadata available for this event.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
