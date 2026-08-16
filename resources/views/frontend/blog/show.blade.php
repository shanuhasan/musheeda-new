@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title)
@section('description', $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 150))

@section('content')
<article class="bg-white dark:bg-slate-900">
    <!-- Header -->
    <header class="bg-slate-50 dark:bg-slate-800/50 py-16 sm:py-24 relative overflow-hidden">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center relative z-10">
            
            <nav class="flex justify-center mb-8" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('blog.index') }}" class="text-slate-400 hover:text-slate-500 dark:hover:text-slate-300">
                                <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">Blog Home</span>
                            </a>
                        </div>
                    </li>
                    @if($post->categories->isNotEmpty())
                    <li>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 flex-shrink-0 text-slate-300 dark:text-slate-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="{{ route('blog.category', $post->categories->first()->slug) }}" class="ml-4 text-sm font-medium text-slate-500 hover:text-brand-600 dark:text-slate-400 dark:hover:text-brand-400">{{ $post->categories->first()->name }}</a>
                        </div>
                    </li>
                    @endif
                </ol>
            </nav>

            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl md:text-6xl mb-6">
                {{ $post->title }}
            </h1>
            
            <div class="flex flex-wrap items-center justify-center gap-4 text-sm text-slate-500 dark:text-slate-400">
                <div class="flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center dark:bg-slate-700 text-brand-600 font-bold dark:text-brand-400">
                        {{ strtoupper(substr($post->author->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="font-medium text-slate-900 dark:text-slate-200">{{ $post->author->name ?? 'Anonymous' }}</span>
                </div>
                <span>&middot;</span>
                <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('F d, Y') }}</time>
                <span>&middot;</span>
                <span>{{ $post->reading_time_minutes }} min read</span>
            </div>
        </div>
    </header>

    <!-- Featured Image -->
    @if($post->hasMedia('featured_image'))
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 -mt-12 sm:-mt-16 relative z-20">
        <div class="rounded-2xl overflow-hidden shadow-xl ring-1 ring-slate-900/5 aspect-[2/1]">
            <img src="{{ $post->getFirstMediaUrl('featured_image', 'optimized') }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
    </div>
    @endif

    <!-- Content Area -->
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="prose prose-lg prose-slate dark:prose-invert max-w-none prose-a:text-brand-600 hover:prose-a:text-brand-500 dark:prose-a:text-brand-400 dark:hover:prose-a:text-brand-300 prose-img:rounded-xl">
            {!! $post->sanitized_content !!}
        </div>
        
        <!-- Tags -->
        @if($post->tags->isNotEmpty())
        <div class="mt-16 pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-wrap items-center gap-3">
            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Tags:</span>
            @foreach($post->tags as $tag)
                <a href="{{ route('blog.tag', $tag->slug) }}" class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-brand-100 hover:text-brand-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-brand-500/20 dark:hover:text-brand-400 transition-colors">
                    #{{ $tag->name }}
                </a>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->isNotEmpty())
    <div class="bg-slate-50 dark:bg-slate-800/30 py-16 border-t border-slate-200 dark:border-slate-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white mb-10 text-center">Read Next</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $related)
                <article class="flex flex-col items-start justify-between rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 transition-all hover:shadow-md dark:bg-slate-800 dark:ring-slate-700/50 group overflow-hidden">
                    <div class="w-full h-48 overflow-hidden bg-slate-100 dark:bg-slate-700 relative">
                        @if($related->hasMedia('featured_image'))
                            <img src="{{ $related->getFirstMediaUrl('featured_image', 'featured') }}" alt="{{ $related->title }}" loading="lazy" class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col justify-between p-6 w-full">
                        <div class="flex-1">
                            <div class="flex items-center gap-x-4 text-xs">
                                <time datetime="{{ $related->published_at->toDateString() }}" class="text-slate-500 dark:text-slate-400">{{ $related->published_at->format('M d, Y') }}</time>
                            </div>
                            <div class="group relative mt-3">
                                <h3 class="text-lg font-bold leading-6 text-slate-900 group-hover:text-brand-600 dark:text-white dark:group-hover:text-brand-400 line-clamp-2">
                                    <a href="{{ route('blog.show', $related->slug) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $related->title }}
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</article>
@endsection
