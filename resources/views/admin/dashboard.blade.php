@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
    <p class="text-sm text-gray-500 mt-1">Welcome back, {{ Auth::user()->name }}. Here's what's happening today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <x-admin.stat-card 
        title="Total Pages" 
        value="{{ $metrics['pages']['total'] }}"
        color="blue"
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'
    />
    <x-admin.stat-card 
        title="Total Leads" 
        value="{{ $metrics['leads']['total'] }}"
        color="green"
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
    />
    <x-admin.stat-card 
        title="Published Blogs" 
        value="{{ $metrics['posts']['published'] }}"
        color="indigo"
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>'
    />
    <x-admin.stat-card 
        title="Newsletter Subs" 
        value="{{ $metrics['subscribers']['total'] }}"
        color="pink"
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>'
    />
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content Area -->
    <div class="lg:col-span-2 space-y-6">
        
        <x-admin.recent-list title="Recent Contact Submissions">
            <x-slot:action>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">View All</a>
            </x-slot:action>
            
            @forelse($recent['recent_contacts'] as $item)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors flex justify-between items-center">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">{{ $item->name }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ $item->subject ?? 'No Subject' }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $item->status === 'new' ? 'green' : 'gray' }}-100 text-{{ $item->status === 'new' ? 'green' : 'gray' }}-800">
                        {{ ucfirst($item->status) }}
                    </span>
                    <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500 text-sm">No new contact submissions.</div>
            @endforelse
        </x-admin.recent-list>

        <x-admin.recent-list title="Recent Blog Posts">
            <x-slot:action>
                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">View All</a>
            </x-slot:action>
            
            @forelse($recent['recent_posts'] as $item)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors flex justify-between items-center">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">{{ $item->title }}</h4>
                    <p class="text-xs text-gray-500 mt-1">By {{ $item->author->name ?? 'Unknown' }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $item->status === 'published' ? 'green' : 'yellow' }}-100 text-{{ $item->status === 'published' ? 'green' : 'yellow' }}-800">
                        {{ ucfirst($item->status) }}
                    </span>
                    <p class="text-xs text-gray-400 mt-1">{{ $item->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500 text-sm">No blog posts found.</div>
            @endforelse
        </x-admin.recent-list>

    </div>

    <!-- Sidebar Area -->
    <div class="space-y-6">
        
        <x-admin.recent-list title="Activity Log">
            @forelse($recent['recent_activities'] as $item)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                        {{ substr($item->user->name ?? 'S', 0, 1) }}
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-800">
                        <span class="font-medium text-gray-900">{{ $item->user->name ?? 'System' }}</span> 
                        {{ $item->action }} 
                        <span class="font-medium">{{ class_basename($item->model_type) }}</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $item->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-500 text-sm">No recent activity.</div>
            @endforelse
        </x-admin.recent-list>
        
    </div>
</div>
@endsection
