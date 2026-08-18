@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">Create Post</h2>
    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Publish a new article to your blog.</p>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    @csrf
    
    <div class="lg:col-span-2 space-y-6">
        <!-- Main Content -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <div class="space-y-5">
                <div>
                    <label for="title" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                    @error('title') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="slug" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Slug (Optional)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                </div>

                <div>
                    <label for="author_id" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Author</label>
                    <select name="author_id" id="author_id" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('author_id', auth()->id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="excerpt" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="3" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">{{ old('excerpt') }}</textarea>
                </div>

                <div>
                    <label for="content" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Content</label>
                    <textarea name="content" id="content" class="tinymce">{{ old('content') }}</textarea>
                    @error('content') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex items-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <input type="checkbox" name="show_toc" id="show_toc" value="1" {{ old('show_toc') ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-brand-500 focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-900">
                    <label for="show_toc" class="text-sm font-medium text-slate-800 dark:text-white/90">Show Table of Contents</label>
                </div>
            </div>
        </div>

        <!-- FAQs -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6" x-data="{ faqs: {{ json_encode(old('faqs', [])) }} }">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white/90">Frequently Asked Questions</h3>
                    <p class="text-sm text-slate-500">Add FAQs to generate FAQ schema automatically.</p>
                </div>
                <button type="button" @click="faqs.push({question: '', answer: ''})" class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 transition-all">
                    + Add FAQ
                </button>
            </div>
            
            <div class="space-y-4">
                <template x-for="(faq, index) in faqs" :key="index">
                    <div class="p-4 rounded-lg border border-slate-100 bg-slate-50 dark:bg-slate-900/50 dark:border-slate-800 relative">
                        <button type="button" @click="faqs.splice(index, 1)" class="absolute top-3 right-3 text-slate-400 hover:text-error-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        <div class="space-y-3 pr-8">
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-800 dark:text-white/90" x-text="'Question ' + (index + 1)"></label>
                                <input type="text" :name="'faqs['+index+'][question]'" x-model="faq.question" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-800 transition-all" required>
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-800 dark:text-white/90">Answer</label>
                                <textarea :name="'faqs['+index+'][answer]'" x-model="faq.answer" rows="2" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-800 transition-all" required></textarea>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="faqs.length === 0" class="text-sm text-slate-500 italic text-center py-4">No FAQs added yet.</div>
            </div>
        </div>
        
        <!-- SEO -->
        @include('admin.partials.seo-form', ['model' => new \App\Models\Post()])
    </div>
    
    <div class="space-y-6">
        <!-- Publishing -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Publishing</h3>
            
            <div class="space-y-4">
                <div>
                    <label for="status" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Status</label>
                    <select name="status" id="status" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                
                <div>
                    <label for="published_at" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Publish Date</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 transition-all">
                </div>
                
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-5 w-5 rounded border-slate-300 text-brand-500 focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-900">
                    <label for="is_featured" class="text-sm font-medium text-slate-800 dark:text-white/90">Featured Post</label>
                </div>

                <button type="submit" class="w-full inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600">
                    Save Post
                </button>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Featured Image</h3>
            <div class="space-y-4">
                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100 dark:file:bg-brand-500/20 dark:file:text-brand-400">
                
                <div>
                    <label for="featured_image_alt" class="mb-2 block text-sm font-medium text-slate-800 dark:text-white/90">Image Alt Text</label>
                    <input type="text" name="featured_image_alt" id="featured_image_alt" value="{{ old('featured_image_alt') }}" placeholder="Describe the image for SEO" class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-sm outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Categories</h3>
            <div class="max-h-48 overflow-y-auto space-y-2">
                @foreach($categories as $category)
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="categories[]" id="cat_{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500">
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
                    <input type="checkbox" name="tags[]" id="tag_{{ $tag->id }}" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                    <label for="tag_{{ $tag->id }}" class="text-sm text-slate-700 dark:text-slate-300">{{ $tag->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Related Posts -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
            <h3 class="mb-4 text-lg font-bold text-slate-800 dark:text-white/90">Related Posts</h3>
            <div class="max-h-48 overflow-y-auto space-y-2">
                @foreach($posts as $p)
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="related_posts[]" id="related_{{ $p->id }}" value="{{ $p->id }}" {{ in_array($p->id, old('related_posts', [])) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                    <label for="related_{{ $p->id }}" class="text-sm text-slate-700 dark:text-slate-300 line-clamp-1">{{ $p->title }}</label>
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
