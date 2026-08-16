<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Musheeda') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body
    x-data="{ page: 'dashboard', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900 text-bodydark': darkMode === true}"
    class="font-sans text-base font-normal text-slate-500 bg-slate-50"
>
    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        
        <!-- ===== Sidebar Start ===== -->
        <aside
            :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
            class="sidebar fixed left-0 top-0 z-[9999] flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-slate-200 bg-white px-5 dark:border-slate-800 dark:bg-black lg:static lg:translate-x-0 transition-transform duration-300 ease-in-out"
            @click.outside="sidebarToggle = false"
        >
            <!-- SIDEBAR HEADER -->
            <div class="flex items-center gap-2 pt-8 sidebar-header pb-7" :class="sidebarToggle ? 'justify-center' : 'justify-between'">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <span class="logo text-2xl font-black text-slate-800 dark:text-white" :class="sidebarToggle ? 'hidden' : 'block'">
                        Musheeda CMS
                    </span>
                    <span class="logo-icon text-2xl font-black text-brand-500" :class="sidebarToggle ? 'block' : 'hidden'">
                        M
                    </span>
                </a>
            </div>

            <!-- SIDEBAR MENU -->
            <div class="flex flex-col overflow-y-auto duration-300 ease-linear custom-scrollbar">
                <nav class="mt-4" x-data="{selected: $persist('Dashboard')}">
                    <div>
                        <h3 class="mb-4 text-xs uppercase leading-[20px] text-slate-400">
                            <span class="menu-group-title" :class="sidebarToggle ? 'hidden lg:block' : 'block'">Main Menu</span>
                        </h3>
                        <ul class="flex flex-col gap-2 mb-6">
                            
                            <!-- Dashboard -->
                            <li>
                                <a
                                    href="{{ route('admin.dashboard') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Dashboard</span>
                                </a>
                            </li>

                            @can('manage_pages')
                            <!-- Pages -->
                            <li>
                                <a
                                    href="{{ route('admin.pages.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.pages.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Pages</span>
                                </a>
                            </li>
                            @endcan

                            @can('manage_pages')
                            <!-- Posts -->
                            <li>
                                <a
                                    href="{{ route('admin.posts.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.posts.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Posts</span>
                                </a>
                            </li>

                            <!-- Categories -->
                            <li>
                                <a
                                    href="{{ route('admin.categories.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.categories.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Categories</span>
                                </a>
                            </li>

                            <!-- Tags -->
                            <li>
                                <a
                                    href="{{ route('admin.tags.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.tags.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Tags</span>
                                </a>
                            </li>
                            @endcan

                            <!-- Media Library -->
                            <li>
                                <a
                                    href="{{ route('admin.media.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.media.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Media Library</span>
                                </a>
                            </li>

                            @can('manage_settings')
                            <!-- Menus -->
                            <li>
                                <a
                                    href="{{ route('admin.menus.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.menus.*') || request()->routeIs('admin.menu-items.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4 6h16M4 12h16m-7 6h7"></path>
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Menus</span>
                                </a>
                            </li>

                            <!-- Settings -->
                            <li>
                                <a
                                    href="{{ route('admin.settings.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.settings.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Settings</span>
                                </a>
                            </li>

                            <!-- Redirects -->
                            <li>
                                <a
                                    href="{{ route('admin.redirects.index') }}"
                                    class="group relative flex items-center gap-3 rounded-lg px-3 py-2.5 font-medium transition-colors"
                                    :class="request()->routeIs('admin.redirects.*') ? 'bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800'"
                                >
                                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : 'block'">Redirects</span>
                                </a>
                            </li>
                            @endcan
                    </div>
                </nav>
            </div>
        </aside>
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            
            <!-- ===== Header Start ===== -->
            <header class="sticky top-0 z-[999] flex w-full border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                <div class="flex grow items-center justify-between px-4 py-4 md:px-6 2xl:px-10">
                    <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
                        <!-- Hamburger Toggle BTN -->
                        <button
                            class="z-[99999] block rounded-sm border border-slate-200 bg-white p-1.5 shadow-sm dark:border-slate-800 dark:bg-slate-900 lg:hidden"
                            @click.stop="sidebarToggle = !sidebarToggle"
                        >
                            <span class="relative block h-5 w-5 cursor-pointer">
                                <span class="du-block absolute right-0 h-full w-full">
                                    <span class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-[0] duration-200 ease-in-out dark:bg-white" :class="{ '!w-full delay-300': !sidebarToggle }"></span>
                                    <span class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-150 duration-200 ease-in-out dark:bg-white" :class="{ '!w-full delay-400': !sidebarToggle }"></span>
                                    <span class="relative top-0 left-0 my-1 block h-0.5 w-0 rounded-sm bg-black delay-200 duration-200 ease-in-out dark:bg-white" :class="{ '!w-full delay-500': !sidebarToggle }"></span>
                                </span>
                            </span>
                        </button>
                    </div>

                    <div class="hidden sm:block">
                        <form action="https://formbold.com/s/unique_form_id" method="POST">
                            <div class="relative">
                                <button class="absolute top-1/2 left-0 -translate-y-1/2">
                                    <svg class="fill-slate-500 hover:fill-brand-500 dark:fill-slate-400 dark:hover:fill-brand-500" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 11.1459 15.8981 12.9431 14.6409 14.288L18.0893 17.7364C18.4147 18.0618 18.4147 18.5894 18.0893 18.9149C17.7638 19.2403 17.2363 19.2403 16.9108 18.9149L13.4624 15.4665C12.285 16.2307 10.7892 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z" fill=""></path>
                                    </svg>
                                </button>

                                <input type="text" placeholder="Type to search..." class="w-full bg-transparent pr-4 pl-9 focus:outline-none xl:w-[430px] border-none focus:ring-0 dark:text-white" />
                            </div>
                        </form>
                    </div>

                    <div class="flex items-center gap-3 2xsm:gap-7">
                        <ul class="flex items-center gap-2 2xsm:gap-4">
                            <!-- Dark Mode Toggler -->
                            <li>
                                <label class="relative m-0 block h-7.5 w-14 rounded-full bg-slate-200 dark:bg-brand-500">
                                    <input type="checkbox" class="absolute top-0 z-50 m-0 h-full w-full cursor-pointer opacity-0" @click="darkMode = !darkMode" />
                                    <span class="absolute top-1/2 left-[3px] flex h-6 w-6 -translate-y-1/2 translate-x-0 items-center justify-center rounded-full bg-white shadow-sm duration-75 ease-linear dark:!right-[3px] dark:!translate-x-full">
                                        <span class="dark:hidden">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7.99993 2.14659C8.36215 2.14659 8.65593 1.85282 8.65593 1.49059V1.02184C8.65593 0.659616 8.36215 0.365845 7.99993 0.365845C7.6377 0.365845 7.34393 0.659616 7.34393 1.02184V1.49059C7.34393 1.85282 7.6377 2.14659 7.99993 2.14659Z" fill="currentColor"></path>
                                                <!-- Sun rays truncated for brevity -->
                                                <circle cx="8" cy="8" r="3.25" fill="currentColor"></circle>
                                            </svg>
                                        </span>
                                        <span class="hidden dark:inline-block">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12.9248 10.1557C10.7483 10.1557 8.98363 8.39103 8.98363 6.21448C8.98363 4.88725 9.64205 3.71261 10.6385 3.01162C10.8715 2.84758 10.963 2.53503 10.8528 2.26127C10.7427 1.98751 10.4578 1.82103 10.1654 1.86016C6.73277 2.31952 4.10397 5.25055 4.10397 8.81845C4.10397 12.7237 7.27027 15.89 11.1755 15.89C13.8824 15.89 16.2343 14.3644 17.2917 12.0163C17.4116 11.7505 17.3062 11.4393 17.0428 11.2829C16.7794 11.1264 16.4385 11.1611 16.2087 11.3695C15.2894 12.2032 14.1206 12.697 12.9248 12.697Z" fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </span>
                                </label>
                            </li>
                        </ul>

                        <!-- User Area -->
                        <div class="relative" x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false">
                            <a class="flex items-center gap-4 cursor-pointer" @click.prevent="dropdownOpen = ! dropdownOpen">
                                <span class="hidden text-right lg:block">
                                    <span class="block text-sm font-medium text-slate-800 dark:text-white">{{ Auth::user()->name }}</span>
                                    <span class="block text-xs font-medium text-slate-500">{{ Auth::user()->roles->first()->name ?? 'Admin' }}</span>
                                </span>
                                <span class="h-10 w-10 rounded-full flex items-center justify-center bg-brand-500 text-white font-bold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </span>
                            </a>

                            <!-- Dropdown -->
                            <div x-show="dropdownOpen" class="absolute right-0 mt-4 flex w-62.5 flex-col rounded-xl border border-slate-200 bg-white shadow-lg dark:border-slate-800 dark:bg-slate-900 w-48">
                                <form method="POST" action="{{ route('logout') }}" class="p-2">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-3.5 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-brand-500 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-brand-400 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            <main class="h-full">
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                    @yield('content')
                </div>
            </main>
            <!-- ===== Main Content End ===== -->

        </div>
        <!-- ===== Content Area End ===== -->
        
        @stack('scripts')
    </body>
</html>
