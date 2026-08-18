@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('header', 'Activity Logs')

@section('content')
<div class="mb-6 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4">
    <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
            <label for="user_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">User</label>
            <select name="user_id" id="user_id" class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-500 focus:ring-brand-500">
                <option value="">All Users</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="flex-1 min-w-[200px]">
            <label for="action" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Action</label>
            <select name="action" id="action" class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-500 focus:ring-brand-500">
                <option value="">All Actions</option>
                @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                        {{ ucfirst($action) }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div>
            <button type="submit" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 font-medium transition-colors ml-2">
                Clear
            </a>
        </div>
    </form>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
            <thead class="bg-slate-50 dark:bg-slate-900/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">User</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Action</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Subject</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">IP Address</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-750 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                            {{ $log->created_at->format('M d, Y H:i:s') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($log->user)
                                    <div class="h-8 w-8 rounded-full bg-brand-100 text-brand-700 dark:bg-brand-900/30 dark:text-brand-400 flex items-center justify-center font-bold mr-3">
                                        {{ substr($log->user->name, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $log->user->name }}</span>
                                @else
                                    <span class="text-sm text-slate-500 dark:text-slate-400 italic">System / Guest</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $badgeColor = match($log->action) {
                                    'login' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'logout' => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300',
                                    'create' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    'update' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
                                    'delete' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    'publish' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                    'unpublish' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                                    default => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $badgeColor }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                            @if($log->model_type)
                                <div class="font-mono text-xs mb-1 text-slate-500">{{ class_basename($log->model_type) }} #{{ $log->model_id }}</div>
                            @endif
                            @if($log->description)
                                <div class="font-medium text-slate-900 dark:text-white line-clamp-1" title="{{ $log->description }}">{{ $log->description }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-mono">
                            {{ $log->ip_address ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="text-brand-600 hover:text-brand-900 dark:text-brand-400 dark:hover:text-brand-300">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                            No activity logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
