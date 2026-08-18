@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-gray-200 leading-tight">
            {{ __('Lead Details') }}
        </h2>
        <a href="{{ route('admin.leads.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Leads</a>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Lead Information -->
                <div class="md:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Contact Information</h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">Name</p>
                                    <p class="font-medium">{{ $lead->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Company</p>
                                    <p class="font-medium">{{ $lead->company ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium"><a href="mailto:{{ $lead->email }}" class="text-indigo-600">{{ $lead->email ?? 'N/A' }}</a></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <p class="font-medium"><a href="tel:{{ $lead->phone }}" class="text-indigo-600">{{ $lead->phone ?? 'N/A' }}</a></p>
                                </div>
                            </div>

                            <h3 class="text-lg font-bold mt-6 mb-4 border-b pb-2">Message</h3>
                            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-md whitespace-pre-wrap">
                                {{ $lead->message ?? 'No message provided.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Submission Details</h3>
                            
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div><span class="text-gray-500">Source:</span> <span class="capitalize">{{ $lead->source }}</span></div>
                                <div><span class="text-gray-500">Submitted:</span> {{ $lead->created_at->format('M d, Y h:i A') }}</div>
                                
                                @if($lead->landing_page)
                                <div><span class="text-gray-500">Landing Page:</span> {{ $lead->landing_page }}</div>
                                @endif
                                
                                @if($lead->product_service)
                                <div><span class="text-gray-500">Product/Service:</span> {{ $lead->product_service }}</div>
                                @endif

                                <div><span class="text-gray-500">IP Address:</span> {{ $lead->ip_address }}</div>
                                
                                <div class="col-span-2">
                                    <span class="text-gray-500">User Agent:</span> 
                                    <p class="text-xs text-gray-400 mt-1">{{ $lead->user_agent }}</p>
                                </div>
                            </div>

                            <!-- UTM Parameters -->
                            @if($lead->utm_source || $lead->utm_medium || $lead->utm_campaign)
                                <h4 class="font-semibold mt-6 mb-2">UTM Parameters</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 dark:bg-gray-900 p-4 rounded">
                                    <div><span class="text-gray-500">Source:</span> {{ $lead->utm_source ?? 'N/A' }}</div>
                                    <div><span class="text-gray-500">Medium:</span> {{ $lead->utm_medium ?? 'N/A' }}</div>
                                    <div><span class="text-gray-500">Campaign:</span> {{ $lead->utm_campaign ?? 'N/A' }}</div>
                                    <div><span class="text-gray-500">Term:</span> {{ $lead->utm_term ?? 'N/A' }}</div>
                                    <div><span class="text-gray-500">Content:</span> {{ $lead->utm_content ?? 'N/A' }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Update Form Sidebar -->
                <div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-6">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h3 class="text-lg font-bold mb-4 border-b pb-2">Manage Lead</h3>
                            
                            <form action="{{ route('admin.leads.update', $lead) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="new" {{ $lead->status == 'new' ? 'selected' : '' }}>New</option>
                                        <option value="contacted" {{ $lead->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="qualified" {{ $lead->status == 'qualified' ? 'selected' : '' }}>Qualified</option>
                                        <option value="lost" {{ $lead->status == 'lost' ? 'selected' : '' }}>Lost</option>
                                        <option value="converted" {{ $lead->status == 'converted' ? 'selected' : '' }}>Converted</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Assigned Admin</label>
                                    <select name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Unassigned</option>
                                        @foreach($admins as $admin)
                                            <option value="{{ $admin->id }}" {{ $lead->assigned_to == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Admin Notes</label>
                                    <textarea name="notes" rows="6" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $lead->notes) }}</textarea>
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                    Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
