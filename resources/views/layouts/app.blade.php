<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <x-seo :model="$seoModel ?? null" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <x-tracking-scripts />
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ mobileMenuOpen: false }">
        
        <!-- Header -->
        <header 
            x-data="{ scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 20)"
            :class="{'bg-white/90 backdrop-blur-md shadow-sm border-slate-200': scrolled, 'bg-white border-slate-200': !scrolled}"
            class="fixed w-full top-0 z-50 transition-all duration-300 border-b"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-2xl font-black text-brand-600 tracking-tight flex items-center gap-2">
                            <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white text-lg">
                                {{ substr(setting('header_logo', setting('site_name', 'Musheeda')), 0, 1) }}
                            </div>
                            {{ setting('header_logo', setting('site_name', 'Musheeda')) }}
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex space-x-8">
                        <!-- Dynamic Services Dropdown -->
                        @if(isset($headerServices) && $headerServices->count() > 0)
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <a href="/services" class="text-slate-600 hover:text-brand-600 inline-flex items-center px-1 pt-1 font-semibold transition-colors">
                                    Services
                                    <svg class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </a>
                                
                                <div x-show="open" x-transition.opacity.duration.200ms class="absolute left-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black/5 z-50 overflow-hidden" style="display: none;">
                                    <div class="py-2">
                                        @foreach($headerServices as $headerService)
                                            <a href="{{ url('/services/' . $headerService->slug) }}" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                                {{ $headerService->name }}
                                            </a>
                                        @endforeach
                                        <div class="border-t border-slate-100 mt-1"></div>
                                        <a href="/services" class="block px-5 py-2 text-xs font-bold text-brand-600 hover:bg-brand-50 uppercase tracking-wider text-center transition-colors">
                                            View All
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Dynamic Products Dropdown -->
                        @if(isset($headerProducts) && $headerProducts->count() > 0)
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                <a href="/products" class="text-slate-600 hover:text-brand-600 inline-flex items-center px-1 pt-1 font-semibold transition-colors">
                                    Products
                                    <svg class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </a>
                                
                                <div x-show="open" x-transition.opacity.duration.200ms class="absolute left-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black/5 z-50 overflow-hidden" style="display: none;">
                                    <div class="py-2">
                                        @foreach($headerProducts as $headerProduct)
                                            <a href="{{ url('/products/' . $headerProduct->slug) }}" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                                {{ $headerProduct->name }}
                                            </a>
                                        @endforeach
                                        <div class="border-t border-slate-100 mt-1"></div>
                                        <a href="/products" class="block px-5 py-2 text-xs font-bold text-brand-600 hover:bg-brand-50 uppercase tracking-wider text-center transition-colors">
                                            View All
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @foreach(menu('header') as $item)
                            @if($item->children->count() > 0)
                                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                    <button class="text-slate-600 hover:text-brand-600 inline-flex items-center px-1 pt-1 font-semibold transition-colors">
                                        {{ $item->title }}
                                        <svg class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute left-0 mt-2 w-56 rounded-xl shadow-xl bg-white ring-1 ring-black/5 z-50 overflow-hidden" style="display: none;">
                                        <div class="py-2">
                                            @foreach($item->children as $child)
                                                <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                                                    {{ $child->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ $item->url }}" target="{{ $item->target }}" class="text-slate-600 hover:text-brand-600 inline-flex items-center px-1 pt-1 font-semibold transition-colors">
                                    {{ $item->title }}
                                </a>
                            @endif
                        @endforeach
                    </nav>

                    <!-- CTA Button -->
                    <div class="hidden md:flex items-center">
                        <a href="{{ setting('header_cta_url', '/contact') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-xl text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-500/30 transition-all hover:-translate-y-0.5">
                            {{ setting('header_cta_text', 'Get a Quote') }}
                        </a>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 hover:text-brand-600 hover:bg-brand-50 transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <span class="sr-only">Open main menu</span>
                            <svg :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-collapse class="md:hidden border-t border-slate-200 bg-white/95 backdrop-blur-md shadow-lg absolute w-full" style="display: none;">
                <div class="pt-2 pb-6 space-y-1 px-4">
                    <!-- Dynamic Services Mobile Dropdown -->
                    @if(isset($headerServices) && $headerServices->count() > 0)
                        <div x-data="{ childOpen: false }">
                            <button @click="childOpen = !childOpen" class="w-full flex justify-between items-center py-3 text-base font-bold text-slate-700 border-b border-slate-100">
                                Services
                                <svg :class="{'rotate-180': childOpen}" class="h-5 w-5 text-slate-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="childOpen" class="pl-4 py-2 space-y-2 bg-slate-50/50 rounded-lg mt-1" style="display: none;">
                                @foreach($headerServices as $headerService)
                                    <a href="{{ url('/services/' . $headerService->slug) }}" class="block py-2 text-sm font-medium text-slate-600 hover:text-brand-600">
                                        {{ $headerService->name }}
                                    </a>
                                @endforeach
                                <a href="/services" class="block py-2 text-sm font-bold text-brand-600 hover:text-brand-700">View All Services &rarr;</a>
                            </div>
                        </div>
                    @endif

                    <!-- Dynamic Products Mobile Dropdown -->
                    @if(isset($headerProducts) && $headerProducts->count() > 0)
                        <div x-data="{ childOpen: false }">
                            <button @click="childOpen = !childOpen" class="w-full flex justify-between items-center py-3 text-base font-bold text-slate-700 border-b border-slate-100">
                                Products
                                <svg :class="{'rotate-180': childOpen}" class="h-5 w-5 text-slate-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="childOpen" class="pl-4 py-2 space-y-2 bg-slate-50/50 rounded-lg mt-1" style="display: none;">
                                @foreach($headerProducts as $headerProduct)
                                    <a href="{{ url('/products/' . $headerProduct->slug) }}" class="block py-2 text-sm font-medium text-slate-600 hover:text-brand-600">
                                        {{ $headerProduct->name }}
                                    </a>
                                @endforeach
                                <a href="/products" class="block py-2 text-sm font-bold text-brand-600 hover:text-brand-700">View All Products &rarr;</a>
                            </div>
                        </div>
                    @endif

                    @foreach(menu('header') as $item)
                        @if($item->children->count() > 0)
                            <div x-data="{ childOpen: false }">
                                <button @click="childOpen = !childOpen" class="w-full flex justify-between items-center py-3 text-base font-bold text-slate-700 border-b border-slate-100">
                                    {{ $item->title }}
                                    <svg :class="{'rotate-180': childOpen}" class="h-5 w-5 text-slate-400 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="childOpen" class="pl-4 py-2 space-y-2 bg-slate-50/50 rounded-lg mt-1" style="display: none;">
                                    @foreach($item->children as $child)
                                        <a href="{{ $child->url }}" target="{{ $child->target }}" class="block py-2 text-sm font-medium text-slate-600 hover:text-brand-600">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $item->url }}" target="{{ $item->target }}" class="block py-3 text-base font-bold text-slate-700 hover:text-brand-600 border-b border-slate-100">
                                {{ $item->title }}
                            </a>
                        @endif
                    @endforeach
                    <div class="pt-6">
                        <a href="{{ setting('header_cta_url', '/contact') }}" class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-brand-600 hover:bg-brand-700 shadow-md shadow-brand-500/20">
                            {{ setting('header_cta_text', 'Get a Quote') }}
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Header Ad Slot -->
        <div class="mt-20 pt-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ad-slot placement="header" />
            </div>
        </div>

        <!-- Page Content -->
        <main class="min-h-[60vh] pt-4">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Newsletter Subscription Section -->
        <section class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-newsletter-form 
                    source="global_footer" 
                    title="Stay up to date" 
                    description="Get the latest news, articles, and resources delivered straight to your inbox every month."
                />
            </div>
        </section>

        <!-- Footer Ad Slot -->
        <div class="bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-ad-slot placement="footer" />
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300 relative overflow-hidden">
            <!-- Footer Gradients -->
            <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-700 to-transparent"></div>
            
            <div class="max-w-7xl mx-auto pt-16 pb-8 px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 lg:gap-8 mb-12">
                    
                    <!-- Company Info -->
                    <div class="lg:col-span-2">
                        <a href="/" class="text-2xl font-black text-white tracking-tight flex items-center gap-2 mb-6">
                            <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white text-lg">
                                {{ substr(setting('header_logo', setting('site_name', 'Musheeda')), 0, 1) }}
                            </div>
                            {{ setting('header_logo', setting('site_name', 'Musheeda')) }}
                        </a>
                        <p class="text-base text-slate-400 mb-8 leading-relaxed max-w-sm">
                            {{ setting('footer_about', 'Musheeda Solutions provides cutting edge IT services and software solutions designed to accelerate digital transformation.') }}
                        </p>
                        
                        <!-- Socials -->
                        <div class="flex space-x-5">
                            @if(setting('social_facebook'))
                            <a href="{{ setting('social_facebook') }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition-all transform hover:-translate-y-1">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            @endif
                            
                            @if(setting('social_twitter'))
                            <a href="{{ setting('social_twitter') }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition-all transform hover:-translate-y-1">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                            @endif
                            
                            @if(setting('social_linkedin'))
                            <a href="{{ setting('social_linkedin') }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition-all transform hover:-translate-y-1">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" /></svg>
                            </a>
                            @endif

                            @if(setting('social_instagram'))
                            <a href="{{ setting('social_instagram') }}" target="_blank" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-brand-600 hover:text-white transition-all transform hover:-translate-y-1">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" clip-rule="evenodd" /></svg>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Links 1 -->
                    <div>
                        <h3 class="text-sm font-bold text-white tracking-wider uppercase mb-6 relative inline-block">
                            Quick Links
                            <span class="absolute -bottom-2 left-0 w-1/2 h-0.5 bg-brand-500"></span>
                        </h3>
                        <ul class="space-y-4">
                            @foreach(menu('footer_1') as $item)
                                <li>
                                    <a href="{{ $item->url }}" target="{{ $item->target }}" class="text-base text-slate-400 hover:text-brand-400 transition-colors inline-flex items-center group">
                                        <svg class="w-4 h-4 mr-2 text-slate-600 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Footer Links 2 -->
                    <div>
                        <h3 class="text-sm font-bold text-white tracking-wider uppercase mb-6 relative inline-block">
                            Services
                            <span class="absolute -bottom-2 left-0 w-1/2 h-0.5 bg-brand-500"></span>
                        </h3>
                        <ul class="space-y-4">
                            @foreach(menu('footer_2') as $item)
                                <li>
                                    <a href="{{ $item->url }}" target="{{ $item->target }}" class="text-base text-slate-400 hover:text-brand-400 transition-colors inline-flex items-center group">
                                        <svg class="w-4 h-4 mr-2 text-slate-600 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-sm font-bold text-white tracking-wider uppercase mb-6 relative inline-block">
                            Contact Us
                            <span class="absolute -bottom-2 left-0 w-1/2 h-0.5 bg-brand-500"></span>
                        </h3>
                        <ul class="space-y-5">
                            @if(setting('contact_email'))
                            <li class="flex items-start text-base text-slate-400">
                                <div class="mt-1 bg-slate-800 p-2 rounded-lg text-brand-400 mr-3">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <a href="mailto:{{ setting('contact_email') }}" class="hover:text-white transition-colors mt-1 break-all">{{ setting('contact_email') }}</a>
                            </li>
                            @endif
                            
                            @if(setting('contact_phone'))
                            <li class="flex items-start text-base text-slate-400">
                                <div class="mt-1 bg-slate-800 p-2 rounded-lg text-brand-400 mr-3">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <a href="tel:{{ setting('contact_phone') }}" class="hover:text-white transition-colors mt-1">{{ setting('contact_phone') }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
                
                <div class="mt-16 border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-slate-500">
                        {{ setting('footer_copyright', '© ' . date('Y') . ' Musheeda Solutions. All rights reserved.') }}
                    </p>
                    <div class="flex space-x-6 text-sm text-slate-500">
                        <a href="/privacy-policy" class="hover:text-white transition-colors">Privacy Policy</a>
                        <a href="/terms-of-service" class="hover:text-white transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
        @stack('scripts')
        <x-cookie-consent />
    </body>
</html>
