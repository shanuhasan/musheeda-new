@extends('layouts.admin')

@section('content')
@php
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

    $pill = [
        'new' => 'bg-success-50 text-success-700 ring-success-600/20 dark:bg-success-500/10 dark:text-success-400',
        'published' => 'bg-success-50 text-success-700 ring-success-600/20 dark:bg-success-500/10 dark:text-success-400',
        'draft' => 'bg-warning-50 text-warning-700 ring-warning-600/20 dark:bg-warning-500/10 dark:text-warning-400',
        'default' => 'bg-slate-100 text-slate-600 ring-slate-500/15 dark:bg-slate-800 dark:text-slate-400',
    ];
    $canPages = auth()->user()->can('manage_pages');
@endphp

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-[13px] text-slate-500">{{ now()->format('l, j F Y') }}</p>
        <h1 class="mt-1 text-2xl font-semibold text-slate-900 dark:text-white">{{ $greeting }}, {{ Str::before(Auth::user()->name, ' ') }}</h1>
    </div>
    @if($canPages)
        <div class="flex gap-2">
            <a href="{{ route('admin.pages.create') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-[13px] font-medium text-slate-700 hover:border-slate-300 hover:text-slate-900 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300">New page</a>
            <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-3.5 py-2 text-[13px] font-medium text-white hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14M5 12h14"/></svg>
                New post
            </a>
        </div>
    @endif
</div>

<!-- Metrics -->
<div class="mb-8 grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-slate-200 bg-slate-200 dark:border-slate-800 dark:bg-slate-800 lg:grid-cols-4">
    <x-admin.stat-card
        title="Pages"
        :value="number_format($metrics['pages']['total'])"
        :hint="$metrics['pages']['draft'] . ' drafts'"
        :href="$canPages ? route('admin.pages.index') : null"
        icon='<svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5zM14 3v5h5"/></svg>'
    />
    <x-admin.stat-card
        title="Leads"
        :value="number_format($metrics['leads']['total'])"
        :hint="$metrics['leads']['new'] . ' new'"
        :href="route('admin.leads.index')"
        icon='<svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 19v-1a4 4 0 00-4-4H6a4 4 0 00-4 4v1M9 10a3 3 0 100-6 3 3 0 000 6z"/></svg>'
    />
    <x-admin.stat-card
        title="Published posts"
        :value="number_format($metrics['posts']['published'])"
        :hint="'of ' . $metrics['posts']['total']"
        :href="$canPages ? route('admin.posts.index') : null"
        icon='<svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 20h4L19 9a2.828 2.828 0 10-4-4L4 16v4z"/></svg>'
    />
    <x-admin.stat-card
        title="Subscribers"
        :value="number_format($metrics['subscribers']['total'])"
        :href="route('admin.subscribers.index')"
        icon='<svg fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM3 7l9 6 9-6"/></svg>'
    />
</div>

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <div class="space-y-6 xl:col-span-2">

        <x-admin.recent-list title="Recent enquiries">
            <x-slot:action>
                <a href="{{ route('admin.leads.index') }}" class="text-[13px] font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white">View all &rarr;</a>
            </x-slot:action>

            @forelse($recent['recent_contacts'] as $item)
                <div class="flex items-center justify-between gap-4 px-5 py-3.5 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/40">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-slate-100 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ mb_strtoupper(mb_substr($item->name, 0, 1)) }}</span>
                        <div class="min-w-0">
                            <p class="truncate text-[13px] font-medium text-slate-900 dark:text-white">{{ $item->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ $item->subject ?? ($item->email ?? 'No subject') }}</p>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-4">
                        <span class="hidden text-xs text-slate-400 sm:inline">{{ $item->created_at->diffForHumans(null, true) }}</span>
                        <span class="inline-flex rounded-full px-2 py-0.5 text-[11px] font-medium capitalize ring-1 ring-inset {{ $pill[$item->status] ?? $pill['default'] }}">{{ $item->status }}</span>
                    </div>
                </div>
            @empty
                <p class="px-5 py-10 text-center text-[13px] text-slate-500">No enquiries yet.</p>
            @endforelse
        </x-admin.recent-list>

        <x-admin.recent-list title="Recent posts">
            @if($canPages)
                <x-slot:action>
                    <a href="{{ route('admin.posts.index') }}" class="text-[13px] font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white">View all &rarr;</a>
                </x-slot:action>
            @endif

            @forelse($recent['recent_posts'] as $item)
                <div class="flex items-center justify-between gap-4 px-5 py-3.5 transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/40">
                    <div class="min-w-0">
                        <p class="truncate text-[13px] font-medium text-slate-900 dark:text-white">{{ $item->title }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $item->author->name ?? 'Unknown' }} &middot; {{ $item->created_at->format('M j, Y') }}</p>
                    </div>
                    <span class="inline-flex shrink-0 rounded-full px-2 py-0.5 text-[11px] font-medium capitalize ring-1 ring-inset {{ $pill[$item->status] ?? $pill['draft'] }}">{{ $item->status }}</span>
                </div>
            @empty
                <p class="px-5 py-10 text-center text-[13px] text-slate-500">No posts yet.</p>
            @endforelse
        </x-admin.recent-list>
    </div>

    <x-admin.recent-list title="Activity">
        @forelse($recent['recent_activities'] as $item)
            <div class="relative flex gap-3 px-5 py-3.5">
                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                <div class="min-w-0">
                    <p class="text-[13px] leading-snug text-slate-600 dark:text-slate-400">
                        <span class="font-medium text-slate-900 dark:text-white">{{ $item->user->name ?? 'System' }}</span>
                        {{ $item->action }}
                        <span class="text-slate-900 dark:text-slate-200">{{ class_basename($item->model_type) }}</span>
                    </p>
                    <p class="mt-0.5 text-xs text-slate-400">{{ $item->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <p class="px-5 py-10 text-center text-[13px] text-slate-500">No recent activity.</p>
        @endforelse
    </x-admin.recent-list>
</div>
@endsection
