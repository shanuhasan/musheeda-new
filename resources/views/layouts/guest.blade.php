<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|instrument-serif:400,400i&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/admin.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased">
        <div class="grid min-h-screen lg:grid-cols-2">
            <!-- Brand panel -->
            <aside class="relative hidden flex-col justify-between overflow-hidden bg-slate-950 p-12 text-white lg:flex">
                <div class="bg-grid-light pointer-events-none absolute inset-0 [mask-image:radial-gradient(ellipse_at_bottom_left,black,transparent_70%)]" aria-hidden="true"></div>
                <a href="/" class="relative flex items-center gap-2.5">
                    <span class="grid h-8 w-8 place-items-center rounded-md bg-white font-display text-lg leading-none text-slate-950">{{ mb_substr(config('app.name', 'M'), 0, 1) }}</span>
                    <span class="text-[17px] font-semibold tracking-tight">{{ config('app.name', 'Musheeda') }}</span>
                </a>
                <p class="relative max-w-md font-display text-5xl leading-[1.05] tracking-tight">
                    Everything your website needs, <em class="text-brand-300">in one quiet place.</em>
                </p>
                <p class="relative text-xs text-slate-500">&copy; {{ date('Y') }} {{ config('app.name', 'Musheeda') }}</p>
            </aside>

            <!-- Form -->
            <main class="flex flex-col items-center justify-center bg-slate-50 px-6 py-16">
                <a href="/" class="mb-10 flex items-center gap-2.5 lg:hidden">
                    <span class="grid h-8 w-8 place-items-center rounded-md bg-slate-900 font-display text-lg leading-none text-white">{{ mb_substr(config('app.name', 'M'), 0, 1) }}</span>
                    <span class="text-[17px] font-semibold tracking-tight">{{ config('app.name', 'Musheeda') }}</span>
                </a>
                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
