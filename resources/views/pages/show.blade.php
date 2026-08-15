<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $page->seo->meta_title ?? $page->title }} | {{ config('app.name', 'Musheeda Solutions') }}</title>
    @if($page->seo?->meta_description)
    <meta name="description" content="{{ $page->seo->meta_description }}">
    @endif
    @if($page->seo?->meta_keywords)
    <meta name="keywords" content="{{ $page->seo->meta_keywords }}">
    @endif
    @if($page->seo?->canonical_url)
    <link rel="canonical" href="{{ $page->seo->canonical_url }}">
    @endif
    @if($page->seo?->robots)
    <meta name="robots" content="{{ $page->seo->robots }}">
    @endif

    <!-- Open Graph Tags -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $page->seo->og_title ?? $page->seo->meta_title ?? $page->title }}">
    @if($page->seo?->og_description ?? $page->seo?->meta_description)
    <meta property="og:description" content="{{ $page->seo->og_description ?? $page->seo->meta_description }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    @if($page->hasMedia('featured_image'))
    <meta property="og:image" content="{{ $page->getFirstMediaUrl('featured_image') }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Quill JS styling for frontend rendering */
        .prose img { border-radius: 0.5rem; }
        .prose iframe { width: 100%; aspect-ratio: 16/9; border-radius: 0.5rem; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    
    <!-- Simple Header (Replace with your dynamic global navigation later) -->
    <header class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                        Musheeda
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/about-us" class="text-sm font-medium text-gray-600 hover:text-indigo-600">About</a>
                    <a href="/services" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Services</a>
                    <a href="/contact-us" class="text-sm font-medium text-gray-600 hover:text-indigo-600">Contact</a>
                    @auth
                        @can('manage_pages')
                            <a href="{{ route('admin.dashboard') }}" class="ml-4 px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Admin Dashboard</a>
                        @endcan
                    @endauth
                </div>
            </div>
        </div>
    </header>

    @if(request()->query('preview') === 'true')
    <div class="bg-yellow-50 border-b border-yellow-200 px-4 py-2 text-center text-sm font-medium text-yellow-800">
        You are viewing this page in PREVIEW mode. Status: {{ strtoupper($page->status) }}
    </div>
    @endif

    <main class="min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-gray-50 py-16 sm:py-24 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    {{ $page->title }}
                </h1>
                
                @if($page->author && $page->published_at)
                <div class="mt-6 flex items-center justify-center space-x-3 text-sm text-gray-500">
                    <div class="font-medium text-gray-900">{{ $page->author->name }}</div>
                    <span>&middot;</span>
                    <time datetime="{{ $page->published_at->toIso8601String() }}">{{ $page->published_at->format('M d, Y') }}</time>
                </div>
                @endif
            </div>
        </div>

        <!-- Featured Image -->
        @if($page->hasMedia('featured_image'))
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 sm:-mt-16 relative z-20">
            <img class="w-full h-auto max-h-[500px] object-cover rounded-2xl shadow-xl border-4 border-white" src="{{ $page->getFirstMediaUrl('featured_image') }}" alt="{{ $page->title }}">
        </div>
        @endif

        <!-- Page Content -->
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="prose prose-lg prose-indigo mx-auto text-gray-600">
                {!! $page->content !!}
            </div>
        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="bg-gray-50 py-12 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Musheeda Solutions. All rights reserved.
        </div>
    </footer>
</body>
</html>
