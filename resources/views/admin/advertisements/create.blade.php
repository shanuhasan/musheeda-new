@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-gray-200 leading-tight">
            {{ __('Create Advertisement') }}
        </h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.advertisements.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name / Identifier</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                        </div>

                        <div class="mb-4">
                            <label for="placement" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Placement Area</label>
                            <select name="placement" id="placement" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                                <option value="header" {{ old('placement') == 'header' ? 'selected' : '' }}>Header (Top of page)</option>
                                <option value="before_blog" {{ old('placement') == 'before_blog' ? 'selected' : '' }}>Before Blog Content</option>
                                <option value="after_paragraph" {{ old('placement') == 'after_paragraph' ? 'selected' : '' }}>After Content Paragraph (In Article)</option>
                                <option value="sidebar" {{ old('placement') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                                <option value="before_related" {{ old('placement') == 'before_related' ? 'selected' : '' }}>Before Related Posts</option>
                                <option value="after_article" {{ old('placement') == 'after_article' ? 'selected' : '' }}>After Article</option>
                                <option value="footer" {{ old('placement') == 'footer' ? 'selected' : '' }}>Footer (Bottom of page)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Advertisement Code (HTML / JS)</label>
                            <p class="text-xs text-gray-500 mb-2">Note: Do not include the main AdSense script tag if it's already configured globally.</p>
                            <textarea name="code" id="code" rows="6" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm font-mono text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">{{ old('code') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Active</label>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_lazy" id="is_lazy" value="1" {{ old('is_lazy', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <label for="is_lazy" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                    Lazy Load
                                    <span class="text-xs text-gray-500 block">Load only when visible (improves page speed)</span>
                                </label>
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700">
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.advertisements.index') }}" class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Cancel</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                                Create Advertisement
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
