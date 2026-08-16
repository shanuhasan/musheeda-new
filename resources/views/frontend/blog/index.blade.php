@extends('layouts.app')

@section('title', isset($category) ? "Category: {$category->name}" : (isset($tag) ? "Tag: {$tag->name}" : 'Blog'))

@section('content')
<div class="bg-slate-50 dark:bg-slate-900 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl">
                @if(isset($category))
                    Category: <span class="text-brand-500">{{ $category->name }}</span>
                @elseif(isset($tag))
                    Tag: <span class="text-brand-500">#{{ $tag->name }}</span>
                @else
                    Our Blog
                @endif
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-500 dark:text-slate-400">
                @if(isset($category))
                    {{ $category->description ?? 'Browse posts in this category.' }}
                @else
                    Insights, updates, and stories from our team.
                @endif
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            
            <div class="lg:col-span-3 space-y-12">
                @if($posts->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mt-2 text-lg font-medium text-slate-900 dark:text-white/90">No posts found</h3>
                        <p class="mt-1 text-slate-500 dark:text-slate-400">We couldn't find any posts matching your criteria.</p>
                        @if(request()->has('search') || isset($category) || isset($tag))
                            <a href="{{ route('blog.index') }}" class="mt-6 inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Clear Filters</a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($posts as $post)
                            <article class="flex flex-col items-start justify-between rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition-all hover:shadow-md dark:bg-slate-800 dark:ring-slate-700/50 group overflow-hidden">
                                <div class="w-full h-48 overflow-hidden bg-slate-100 dark:bg-slate-700 relative">
                                    @if($post->hasMedia('featured_image'))
                                        <img src="{{ $post->getFirstMediaUrl('featured_image', 'featured') }}" alt="{{ $post->title }}" loading="lazy" class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full w-full items-center justify-center text-slate-400 dark:text-slate-500">
                                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                    
                                    @if($post->categories->isNotEmpty())
                                        <div class="absolute top-4 left-4">
                                            <span class="inline-flex items-center rounded-full bg-brand-500/90 px-3 py-1 text-xs font-medium text-white backdrop-blur-sm">
                                                {{ $post->categories->first()->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex flex-1 flex-col justify-between p-6 w-full">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-x-4 text-xs">
                                            <time datetime="{{ $post->published_at->toDateString() }}" class="text-slate-500 dark:text-slate-400">{{ $post->published_at->format('M d, Y') }}</time>
                                            <span class="text-slate-500 dark:text-slate-400">&middot;</span>
                                            <span class="text-slate-500 dark:text-slate-400">{{ $post->reading_time_minutes }} min read</span>
                                        </div>
                                        <div class="group relative mt-3">
                                            <h3 class="text-xl font-bold leading-6 text-slate-900 group-hover:text-brand-600 dark:text-white dark:group-hover:text-brand-400 line-clamp-2">
                                                <a href="{{ route('blog.show', $post->slug) }}">
                                                    <span class="absolute inset-0"></span>
                                                    {{ $post->title }}
                                                </a>
                                            </h3>
                                            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="relative mt-6 flex items-center gap-x-4 border-t border-slate-100 pt-4 dark:border-slate-700/50">
                                        <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center dark:bg-slate-700 text-brand-600 font-bold dark:text-brand-400">
                                            {{ strtoupper(substr($post->author->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div class="text-sm leading-6">
                                            <p class="font-semibold text-slate-900 dark:text-white">
                                                <span class="absolute inset-0"></span>
                                                {{ $post->author->name ?? 'Anonymous' }}
                                            </p>
                                            <p class="text-slate-500 dark:text-slate-400">Author</p>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <div class="mt-12">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
            
            <aside class="space-y-8">
                <!-- Search -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800/50">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Search</h3>
                    <form action="{{ route('blog.index') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2.5 pr-10 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-600 dark:bg-slate-900 transition-all">
                            <button type="submit" class="absolute right-0 top-0 bottom-0 px-3 flex items-center text-slate-400 hover:text-brand-500">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800/50">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Categories</h3>
                    <ul class="space-y-3">
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('blog.category', $cat->slug) }}" class="flex items-center justify-between text-slate-600 hover:text-brand-500 dark:text-slate-300 dark:hover:text-brand-400 transition-colors {{ isset($category) && $category->id === $cat->id ? 'font-bold text-brand-600 dark:text-brand-400' : '' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="inline-flex items-center justify-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-600 dark:bg-slate-700 dark:text-slate-300">{{ $cat->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tags -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-800/50">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $t)
                            <a href="{{ route('blog.tag', $t->slug) }}" class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-brand-100 hover:text-brand-700 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-brand-500/20 dark:hover:text-brand-400 transition-colors {{ isset($tag) && $tag->id === $t->id ? 'bg-brand-50 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400 ring-1 ring-brand-500/30' : '' }}">
                                #{{ $t->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
