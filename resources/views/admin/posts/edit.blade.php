@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">Edit Post</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Update your blog article.</p>
    </div>
    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-slate-100 px-4 py-2 text-center font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
        View Live
    </a>
</div>

<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    @csrf
    @method('PUT')
    
    <div class="lg:col-span-2 space-y-6">
        <!-- Main Content -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <div class="space-y-5">
                <div>
                    <label for="title" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                    @error('title') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="slug" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                </div>

                <div>
                    <label for="excerpt" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">{{ old('excerpt', $post->excerpt) }}</textarea>
                </div>

                <div>
                    <label for="content" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Content</label>
                    <textarea name="content" id="content" class="tinymce">{{ old('content', $post->content) }}</textarea>
                    @error('content') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        
        <!-- SEO -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">SEO Optimization</h3>
            <div class="space-y-5">
                <div>
                    <label for="meta_title" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $post->meta_title) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                </div>
                <div>
                    <label for="meta_description" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">{{ old('meta_description', $post->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>
    
    <div class="space-y-6">
        <!-- Publishing -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Publishing</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="status" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Status</label>
                    <select name="status" id="status" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                
                <div>
                    <label for="published_at" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Publish Date</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                </div>
                
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-brand-500 focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-900">
                    <label for="is_featured" class="text-sm font-medium text-slate-800 dark:text-white/90">Featured Post</label>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600">
                    Update Post
                </button>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Featured Image</h3>
            
            @if($post->hasMedia('featured_image'))
                <div class="mb-4">
                    <img src="{{ $post->getFirstMediaUrl('featured_image', 'thumb') }}" alt="Current Featured Image" class="w-full rounded-lg object-cover h-32">
                </div>
            @endif
            
            <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:file:bg-brand-500/20 dark:file:text-brand-400">
        </div>

        <!-- Categories -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Categories</h3>
            <div class="max-h-48 overflow-y-auto space-y-2">
                @foreach($categories as $category)
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="categories[]" id="cat_{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                    <label for="cat_{{ $category->id }}" class="text-sm text-slate-700 dark:text-slate-300">{{ $category->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tags -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Tags</h3>
            <div class="max-h-48 overflow-y-auto space-y-2">
                @foreach($tags as $tag)
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="tags[]" id="tag_{{ $tag->id }}" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                    <label for="tag_{{ $tag->id }}" class="text-sm text-slate-700 dark:text-slate-300">{{ $tag->name }}</label>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '.tinymce',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        height: 500,
    });
</script>
@endpush
