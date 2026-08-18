@extends('layouts.admin')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-gray-200 leading-tight">
            {{ __('Advertisements') }}
        </h2>
        <a href="{{ route('admin.advertisements.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
            Create Advertisement
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
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap">
                            <thead>
                                <tr class="text-left font-bold border-b border-gray-200 dark:border-gray-700">
                                    <th class="pb-4 pt-6 px-6">Name</th>
                                    <th class="pb-4 pt-6 px-6">Placement</th>
                                    <th class="pb-4 pt-6 px-6">Status</th>
                                    <th class="pb-4 pt-6 px-6">Lazy Load</th>
                                    <th class="pb-4 pt-6 px-6">Sort</th>
                                    <th class="pb-4 pt-6 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($advertisements as $ad)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-750">
                                        <td class="px-6 py-4 font-medium">{{ $ad->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 bg-gray-200 dark:bg-gray-700 rounded text-xs text-gray-800 dark:text-gray-200">
                                                {{ $ad->placement }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($ad->is_active)
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Active</span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($ad->is_lazy)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">Yes</span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-semibold">No</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">{{ $ad->sort_order }}</td>
                                        <td class="px-6 py-4 flex gap-3">
                                            <a href="{{ route('admin.advertisements.edit', $ad) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                            <form action="{{ route('admin.advertisements.destroy', $ad) }}" method="POST" class="inline" onsubmit="return confirm('Delete this advertisement?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-8 text-center text-gray-500" colspan="6">No advertisements found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
