@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ isset($page) ? 'Edit Page' : 'Create Page' }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ isset($page) ? 'Update the page content and SEO settings.' : 'Add a new dynamic page to the website.' }}</p>
    </div>
    <a href="{{ route('admin.pages.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">
        &larr; Back to Pages
    </a>
</div>

<!-- Include Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div x-data="{ tab: 'content' }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    
    <div class="border-b border-gray-200 px-6 pt-4 flex space-x-6">
        <button @click="tab = 'content'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'content', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'content' }" class="pb-4 px-1 border-b-2 font-medium text-sm transition-colors">
            General Content
        </button>
        <button @click="tab = 'seo'" :class="{ 'border-indigo-500 text-indigo-600': tab === 'seo', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'seo' }" class="pb-4 px-1 border-b-2 font-medium text-sm transition-colors">
            SEO Settings
        </button>
    </div>

    <form action="{{ isset($page) ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST" enctype="multipart/form-data" id="pageForm">
        @csrf
        @if(isset($page))
            @method('PUT')
        @endif

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content Tab -->
            <div x-show="tab === 'content'" class="space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Page Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $page->title ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL)</label>
                        <div class="mt-1 flex rounded-md shadow-sm">
                            <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-gray-500 sm:text-sm">
                                {{ url('/') }}/
                            </span>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug ?? '') }}" placeholder="Leave blank to auto-generate" class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="draft" {{ old('status', $page->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $page->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Page Content</label>
                    <input type="hidden" name="content" id="content" value="{{ old('content', $page->content ?? '') }}">
                    <div id="editor-container" class="bg-white" style="height: 400px;">{!! old('content', $page->content ?? '') !!}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                    <x-admin.media-picker name="featured_image" :current="isset($page) ? $page->getFirstMediaUrl('featured_image') : null" />
                    <p class="mt-1 text-xs text-gray-500">Max size: 2MB. Recommended format: WEBP/JPG.</p>
                </div>
            </div>

            <!-- SEO Tab -->
            <div x-show="tab === 'seo'" class="space-y-6" style="display: none;">
                
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6 text-sm text-blue-700">
                    <p>These settings dictate how your page appears in Search Engines (Google) and Social Media (Facebook, Twitter).</p>
                </div>

                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->seo->meta_title ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <p class="mt-1 text-xs text-gray-500">If left blank, the Page Title will be used.</p>
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('meta_description', $page->seo->meta_description ?? '') }}</textarea>
                </div>
                
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $page->seo->meta_keywords ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., software, services, consulting">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="canonical_url" class="block text-sm font-medium text-gray-700">Canonical URL</label>
                        <input type="url" name="canonical_url" id="canonical_url" value="{{ old('canonical_url', $page->seo->canonical_url ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="robots" class="block text-sm font-medium text-gray-700">Robots Meta</label>
                        <input type="text" name="robots" id="robots" value="{{ old('robots', $page->seo->robots ?? 'index, follow') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <hr class="border-gray-200">
                <h3 class="text-sm font-semibold text-gray-800">Open Graph (Social Media)</h3>

                <div>
                    <label for="og_title" class="block text-sm font-medium text-gray-700">OG Title</label>
                    <input type="text" name="og_title" id="og_title" value="{{ old('og_title', $page->seo->og_title ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="og_description" class="block text-sm font-medium text-gray-700">OG Description</label>
                    <textarea name="og_description" id="og_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('og_description', $page->seo->og_description ?? '') }}</textarea>
                </div>
            </div>
            
            <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end">
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ isset($page) ? 'Update Page' : 'Save Page' }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Write amazing content here...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            }
        });

        // Sync Quill content to hidden input before form submission
        var form = document.getElementById('pageForm');
        var contentInput = document.getElementById('content');
        
        form.onsubmit = function() {
            var html = quill.root.innerHTML;
            if (html === '<p><br></p>') html = '';
            contentInput.value = html;
        };
    });
</script>
@endsection
