@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-gray-200 leading-tight">
            {{ __('Leads') }}
        </h2>
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
                    <form method="GET" action="{{ route('admin.leads.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone..." class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="status" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Statuses</option>
                                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                                <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                            </select>
                        </div>
                        <div>
                            <select name="source" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Sources</option>
                                <option value="contact" {{ request('source') == 'contact' ? 'selected' : '' }}>Contact</option>
                                <option value="product" {{ request('source') == 'product' ? 'selected' : '' }}>Product</option>
                                <option value="service" {{ request('source') == 'service' ? 'selected' : '' }}>Service</option>
                                <option value="landing" {{ request('source') == 'landing' ? 'selected' : '' }}>Landing</option>
                                <option value="demo" {{ request('source') == 'demo' ? 'selected' : '' }}>Demo</option>
                                <option value="quote" {{ request('source') == 'quote' ? 'selected' : '' }}>Quote</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                            <a href="{{ route('admin.leads.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Clear
                            </a>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left font-bold">
                                    <th class="pb-4 pt-6 px-6">Name</th>
                                    <th class="pb-4 pt-6 px-6">Source</th>
                                    <th class="pb-4 pt-6 px-6">Status</th>
                                    <th class="pb-4 pt-6 px-6">Date</th>
                                    <th class="pb-4 pt-6 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leads as $lead)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="border-t items-center px-6 py-4">
                                            {{ $lead->name }}<br>
                                            <span class="text-sm text-gray-500">{{ $lead->email ?? $lead->phone }}</span>
                                        </td>
                                        <td class="border-t px-6 py-4 capitalize">
                                            {{ $lead->source }}
                                        </td>
                                        <td class="border-t px-6 py-4">
                                            @php
                                                $statusColor = match($lead->status) {
                                                    'new' => 'bg-blue-100 text-blue-800',
                                                    'contacted' => 'bg-yellow-100 text-yellow-800',
                                                    'qualified' => 'bg-indigo-100 text-indigo-800',
                                                    'converted' => 'bg-green-100 text-green-800',
                                                    'lost' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColor }}">
                                                {{ ucfirst($lead->status) }}
                                            </span>
                                        </td>
                                        <td class="border-t px-6 py-4">
                                            {{ $lead->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="border-t px-6 py-4">
                                            <a href="{{ route('admin.leads.show', $lead) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="border-t px-6 py-4 text-center" colspan="5">No leads found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $leads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
