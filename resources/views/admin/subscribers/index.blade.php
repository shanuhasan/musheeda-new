@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-gray-200 leading-tight">
            {{ __('Subscribers') }}
        </h2>
        <a href="{{ route('admin.subscribers.export', request()->query()) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
            Export to CSV
        </a>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Filters & Search -->
                    <form method="GET" action="{{ route('admin.subscribers.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search email..." class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="status" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Statuses</option>
                                <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                                <option value="subscribed" {{ request('status') == 'subscribed' ? 'selected' : '' }}>Subscribed</option>
                                <option value="unsubscribed" {{ request('status') == 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                            <a href="{{ route('admin.subscribers.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Clear
                            </a>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left font-bold border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-4 pt-6 px-6">Email</th>
                                    <th class="pb-4 pt-6 px-6">Status</th>
                                    <th class="pb-4 pt-6 px-6">Source</th>
                                    <th class="pb-4 pt-6 px-6">Subscribed At</th>
                                    <th class="pb-4 pt-6 px-6">Verified At</th>
                                    <th class="pb-4 pt-6 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscribers as $subscriber)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-750">
                                        <td class="px-6 py-4">
                                            {{ $subscriber->email }}<br>
                                            <span class="text-xs text-gray-500">IP: {{ $subscriber->ip_address ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColor = match($subscriber->status) {
                                                    'subscribed' => 'bg-green-100 text-green-800',
                                                    'unsubscribed' => 'bg-red-100 text-red-800',
                                                    default => 'bg-yellow-100 text-yellow-800'
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColor }}">
                                                {{ ucfirst($subscriber->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-500">{{ Str::limit($subscriber->source, 20) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            {{ $subscriber->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            {{ $subscriber->verified_at ? $subscriber->verified_at->format('M d, Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-center text-gray-500" colspan="6">No subscribers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $subscribers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
