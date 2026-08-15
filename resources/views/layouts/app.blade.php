<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', setting('site_name', 'Musheeda Solutions'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800" x-data="{ mobileMenuOpen: false }">
        
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-2xl font-bold text-brand-600">
                            {{ setting('header_logo', setting('site_name', 'Musheeda')) }}
                        </a>
                    </div>
                    
                    <!-- Desktop Navigation -->
                    <nav class="hidden md:flex space-x-8">
                        @foreach(menu('header') as $item)
                            @if($item->children->count() > 0)
                                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                    <button class="text-slate-600 hover:text-brand-600 inline-flex items-center px-1 pt-1 font-medium transition-colors">
                                        {{ $item->title }}
                                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    
                                    <div x-show="open" x-transition class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                                        <div class="py-1">
                                            @foreach($item->children as $child)
                                                <a href="{{ $child->url }}" target="{{ $child->target }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-600 transition-colors">
                                                    {{ $child->title }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ $item->url }}" target="{{ $item->target }}" class="text-slate-600 hover:text-brand-600 inline-flex items-center px-1 pt-1 font-medium transition-colors">
                                    {{ $item->title }}
                                </a>
                            @endif
                        @endforeach
                    </nav>

                    <!-- CTA Button -->
                    <div class="hidden md:flex items-center">
                        <a href="{{ setting('header_cta_url', '/contact') }}" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 shadow-sm transition-colors">
                            {{ setting('header_cta_text', 'Get a Quote') }}
                        </a>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 transition-colors">
                            <span class="sr-only">Open main menu</span>
                            <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                            <svg x-show="mobileMenuOpen" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div x-show="mobileMenuOpen" x-collapse class="md:hidden border-t border-slate-200 bg-white" style="display: none;">
                <div class="pt-2 pb-3 space-y-1">
                    @foreach(menu('header') as $item)
                        @if($item->children->count() > 0)
                            <div x-data="{ childOpen: false }">
                                <button @click="childOpen = !childOpen" class="w-full flex justify-between items-center pl-3 pr-4 py-2 text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-brand-600">
                                    {{ $item->title }}
                                    <svg :class="{'rotate-180': childOpen}" class="h-4 w-4 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="childOpen" class="pl-6 bg-slate-50" style="display: none;">
                                    @foreach($item->children as $child)
                                        <a href="{{ $child->url }}" target="{{ $child->target }}" class="block pl-3 pr-4 py-2 text-sm font-medium text-slate-500 hover:text-brand-600">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $item->url }}" target="{{ $item->target }}" class="block pl-3 pr-4 py-2 text-base font-medium text-slate-600 hover:bg-slate-50 hover:text-brand-600">
                                {{ $item->title }}
                            </a>
                        @endif
                    @endforeach
                    <div class="p-4">
                        <a href="{{ setting('header_cta_url', '/contact') }}" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-brand-600 hover:bg-brand-700">
                            {{ setting('header_cta_text', 'Get a Quote') }}
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="min-h-[60vh]">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-300">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    
                    <!-- Company Info -->
                    <div class="md:col-span-1">
                        <span class="text-2xl font-bold text-white tracking-tight mb-4 block">
                            {{ setting('header_logo', setting('site_name', 'Musheeda')) }}
                        </span>
                        <p class="text-sm text-slate-400 mb-6 leading-relaxed">
                            {{ setting('footer_about', 'Musheeda Solutions provides cutting edge IT services and software solutions.') }}
                        </p>
                        
                        <!-- Socials -->
                        <div class="flex space-x-4">
                            @if(setting('social_facebook'))
                            <a href="{{ setting('social_facebook') }}" target="_blank" class="text-slate-400 hover:text-white transition-colors">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            @endif
                            
                            @if(setting('social_twitter'))
                            <a href="{{ setting('social_twitter') }}" target="_blank" class="text-slate-400 hover:text-white transition-colors">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                            </a>
                            @endif
                            
                            @if(setting('social_linkedin'))
                            <a href="{{ setting('social_linkedin') }}" target="_blank" class="text-slate-400 hover:text-white transition-colors">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" /></svg>
                            </a>
                            @endif

                            @if(setting('social_instagram'))
                            <a href="{{ setting('social_instagram') }}" target="_blank" class="text-slate-400 hover:text-white transition-colors">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" clip-rule="evenodd" /></svg>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Links 1 -->
                    <div>
                        <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Quick Links</h3>
                        <ul class="space-y-3">
                            @foreach(menu('footer_1') as $item)
                                <li>
                                    <a href="{{ $item->url }}" target="{{ $item->target }}" class="text-sm text-slate-400 hover:text-white transition-colors">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Footer Links 2 -->
                    <div>
                        <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Services</h3>
                        <ul class="space-y-3">
                            @foreach(menu('footer_2') as $item)
                                <li>
                                    <a href="{{ $item->url }}" target="{{ $item->target }}" class="text-sm text-slate-400 hover:text-white transition-colors">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-white tracking-wider uppercase mb-4">Contact</h3>
                        <ul class="space-y-3">
                            @if(setting('contact_email'))
                            <li class="flex items-start text-sm text-slate-400">
                                <svg class="h-5 w-5 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:{{ setting('contact_email') }}" class="hover:text-white transition-colors">{{ setting('contact_email') }}</a>
                            </li>
                            @endif
                            
                            @if(setting('contact_phone'))
                            <li class="flex items-start text-sm text-slate-400">
                                <svg class="h-5 w-5 mr-2 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <a href="tel:{{ setting('contact_phone') }}" class="hover:text-white transition-colors">{{ setting('contact_phone') }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    
                </div>
                
                <div class="mt-12 border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-slate-400">
                        {{ setting('footer_copyright', '© 2026 Musheeda Solutions. All rights reserved.') }}
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>
