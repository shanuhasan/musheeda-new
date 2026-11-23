<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>{{ config('app.name', 'Musheeda') }} &middot; Admin</title>

    @include('layouts.partials.favicon')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Apply the saved theme before paint to avoid a flash -->
    <script>
        try { if (JSON.parse(localStorage.getItem('darkMode'))) document.documentElement.classList.add('dark'); } catch (e) {}
    </script>

    <!-- Scripts -->
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
</head>
@php
    $icons = [
        'home' => 'M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5v-6h-6v6H4a1 1 0 01-1-1v-9.5z',
        'page' => 'M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8l-5-5zM14 3v5h5M9 13h6M9 17h4',
        'layout' => 'M4 5a1 1 0 011-1h14a1 1 0 011 1v4H4V5zM4 13h7v7H5a1 1 0 01-1-1v-6zM15 13h5v6a1 1 0 01-1 1h-4v-7z',
        'pen' => 'M4 20h4L19 9a2.828 2.828 0 10-4-4L4 16v4zM13.5 6.5l4 4',
        'briefcase' => 'M9 6V5a2 2 0 012-2h2a2 2 0 012 2v1M4 7h16a1 1 0 011 1v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1zM3 12h18',
        'box' => 'M21 8l-9-5-9 5 9 5 9-5zM3 8v8l9 5 9-5V8M12 13v8',
        'folder' => 'M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z',
        'tag' => 'M3 12V4a1 1 0 011-1h8l9 9-9 9-9-9zM7.5 7.5h.01',
        'users' => 'M16 19v-1a4 4 0 00-4-4H6a4 4 0 00-4 4v1M9 10a3 3 0 100-6 3 3 0 000 6zM22 19v-1a4 4 0 00-3-3.87M16 4.13a3 3 0 010 5.74',
        'mail' => 'M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM3 7l9 6 9-6',
        'megaphone' => 'M3 11v2a1 1 0 001 1h2l5 4V6L6 10H4a1 1 0 00-1 1zM15 9a3 3 0 010 6M18 6a7 7 0 010 12',
        'image' => 'M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM3 16l5-5 4 4 3-3 6 6M15.5 9.5h.01',
        'menu' => 'M4 6h16M4 12h16M4 18h10',
        'cog' => 'M12 15a3 3 0 100-6 3 3 0 000 6zM19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6 1.65 1.65 0 0010 3.09V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z',
        'clock' => 'M12 21a9 9 0 100-18 9 9 0 000 18zM12 7v5l3 3',
        'redirect' => 'M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5',
    ];

    $navGroups = [
        'Overview' => [
            ['Dashboard', 'admin.dashboard', ['admin.dashboard'], 'home', null],
        ],
        'Content' => [
            ['Pages', 'admin.pages.index', ['admin.pages.*'], 'page', 'manage_pages'],
            ['Landing Pages', 'admin.landing-pages.index', ['admin.landing-pages.*'], 'layout', 'manage_pages'],
            ['Posts', 'admin.posts.index', ['admin.posts.*'], 'pen', 'manage_pages'],
            ['Services', 'admin.services.index', ['admin.services.*'], 'briefcase', 'manage_pages'],
            ['Products', 'admin.products.index', ['admin.products.*'], 'box', 'manage_pages'],
            ['Categories', 'admin.categories.index', ['admin.categories.*'], 'folder', 'manage_pages'],
            ['Tags', 'admin.tags.index', ['admin.tags.*'], 'tag', 'manage_pages'],
            ['Media Library', 'admin.media.index', ['admin.media.*'], 'image', null],
        ],
        'Audience' => [
            ['Leads', 'admin.leads.index', ['admin.leads.*'], 'users', null],
            ['Subscribers', 'admin.subscribers.index', ['admin.subscribers.*'], 'mail', null],
            ['Advertisements', 'admin.advertisements.index', ['admin.advertisements.*'], 'megaphone', 'manage_settings'],
        ],
        'System' => [
            ['Menus', 'admin.menus.index', ['admin.menus.*', 'admin.menu-items.*'], 'menu', 'manage_settings'],
            ['Redirects', 'admin.redirects.index', ['admin.redirects.*'], 'redirect', 'manage_settings'],
            ['Activity Logs', 'admin.activity-logs.index', ['admin.activity-logs.*'], 'clock', 'manage_settings'],
            ['Settings', 'admin.settings.index', ['admin.settings.*'], 'cog', 'manage_settings'],
        ],
    ];

    $user = Auth::user();
    $currentLabel = 'Dashboard';
    foreach ($navGroups as $items) {
        foreach ($items as $item) {
            if (request()->routeIs(...$item[2])) { $currentLabel = $item[0]; }
        }
    }
@endphp
<body
    x-data="{ darkMode: false, sidebarOpen: false }"
    x-init="
        darkMode = document.documentElement.classList.contains('dark');
        $watch('darkMode', value => {
            localStorage.setItem('darkMode', JSON.stringify(value));
            document.documentElement.classList.toggle('dark', value);
        })"
    class="admin bg-slate-100 font-sans text-[14px] text-slate-600 antialiased dark:bg-slate-950 dark:text-slate-400"
>
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-950/50 backdrop-blur-sm lg:hidden"></div>

        <!-- Sidebar -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex w-[248px] flex-col bg-slate-950 transition-transform duration-300 ease-out lg:static lg:translate-x-0"
        >
            <div class="flex h-16 shrink-0 items-center gap-2.5 border-b border-white/[0.06] px-5">
                <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 items-center gap-2.5" aria-label="{{ setting('site_name', config('app.name', 'Musheeda')) }} admin">
                    @if(setting('site_logo'))
                        <img src="{{ asset(setting('site_logo')) }}" alt="{{ setting('site_name', config('app.name', 'Musheeda')) }}" class="h-8 w-auto max-w-[160px] object-contain">
                    @else
                        <span class="grid h-7 w-7 place-items-center rounded-md bg-white text-[13px] font-semibold text-slate-950">{{ mb_substr(config('app.name', 'Musheeda'), 0, 1) }}</span>
                        <span class="text-[15px] font-semibold tracking-tight text-white">{{ config('app.name', 'Musheeda') }}</span>
                    @endif
                </a>
                <span class="ml-auto rounded border border-white/10 px-1.5 py-0.5 text-[10px] font-medium uppercase tracking-wider text-slate-500">CMS</span>
            </div>

            <nav class="custom-scrollbar flex-1 overflow-y-auto px-3 pb-6" aria-label="Admin">
                @foreach($navGroups as $group => $items)
                    @php
                        $visible = array_filter($items, fn ($i) => !$i[4] || $user->can($i[4]));
                    @endphp
                    @if(count($visible))
                        <p class="admin-nav-label">{{ $group }}</p>
                        <ul class="space-y-0.5">
                            @foreach($visible as [$label, $route, $patterns, $icon, $perm])
                                @php $active = request()->routeIs(...$patterns); @endphp
                                <li>
                                    <a href="{{ route($route) }}" @class(['admin-nav-link', 'is-active' => $active]) @if($active) aria-current="page" @endif>
                                        <svg fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icons[$icon] }}"/></svg>
                                        {{ $label }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </nav>

            <div class="border-t border-white/[0.06] p-3">
                <a href="{{ url('/') }}" target="_blank" class="admin-nav-link">
                    <svg fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="{{ $icons['redirect'] }}"/></svg>
                    View website
                </a>
            </div>
        </aside>

        <!-- Content -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

            <!-- Top bar -->
            <header class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-4 border-b border-slate-200 bg-white/90 px-4 backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/90 md:px-8">
                <button type="button" @click.stop="sidebarOpen = true" class="-ml-1 grid h-9 w-9 place-items-center rounded-md text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 lg:hidden" aria-label="Open navigation">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>

                <nav class="flex min-w-0 items-center gap-2 text-[13px]" aria-label="Breadcrumb">
                    <a href="{{ route('admin.dashboard') }}" class="hidden text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 sm:inline">Admin</a>
                    <span class="hidden text-slate-300 dark:text-slate-700 sm:inline">/</span>
                    <span class="truncate font-medium text-slate-900 dark:text-white">{{ $currentLabel }}</span>
                </nav>

                <div class="ml-auto flex items-center gap-1.5">
                    <button type="button" @click="darkMode = !darkMode" class="grid h-9 w-9 place-items-center rounded-md text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-white" :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                        <svg x-show="!darkMode" class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.8A9 9 0 1111.2 3a7 7 0 009.8 9.8z"/></svg>
                        <svg x-show="darkMode" x-cloak class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 17a5 5 0 100-10 5 5 0 000 10zM12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                    </button>

                    <span class="mx-1.5 h-6 w-px bg-slate-200 dark:bg-slate-800"></span>

                    <!-- User -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
                        <button type="button" @click="open = !open" :aria-expanded="open" class="flex items-center gap-3 rounded-md py-1 pl-1 pr-2 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800">
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-slate-900 text-xs font-semibold text-white dark:bg-white dark:text-slate-900">
                                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                            </span>
                            <span class="hidden text-left leading-tight md:block">
                                <span class="block text-[13px] font-medium text-slate-900 dark:text-white">{{ $user->name }}</span>
                                <span class="block text-[11px] capitalize text-slate-500">{{ $user->roles->first()->name ?? 'Admin' }}</span>
                            </span>
                            <svg class="hidden h-3.5 w-3.5 text-slate-400 md:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" x-cloak x-transition.opacity.duration.150ms class="absolute right-0 mt-2 w-56 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-xl dark:border-slate-800 dark:bg-slate-900">
                            <div class="border-b border-slate-100 px-4 py-3 dark:border-slate-800">
                                <p class="truncate text-[13px] font-medium text-slate-900 dark:text-white">{{ $user->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                            </div>
                            <div class="p-1">
                                @if(Route::has('profile.edit'))
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 rounded-md px-3 py-2 text-[13px] text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">Profile</a>
                                @endif
                                <a href="{{ url('/') }}" target="_blank" class="flex items-center gap-2.5 rounded-md px-3 py-2 text-[13px] text-slate-700 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">View website</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2.5 rounded-md px-3 py-2 text-left text-[13px] text-error-600 hover:bg-error-50 dark:hover:bg-error-500/10">Log out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main -->
            <main class="flex-1">
                <div class="mx-auto max-w-[1400px] px-4 py-6 md:px-8 md:py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
