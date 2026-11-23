<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @include('layouts.partials.favicon')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600|instrument-serif:400,400i&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/admin.css', 'resources/js/app.js'])
    </head>
    @php
        $siteName = setting('site_name', config('app.name', 'Musheeda'));
        $logo = setting('site_logo');
        // The brand logo has a dark-text twin for light backgrounds (used on small screens).
        $logoOnLight = ($logo && str_contains($logo, 'musheeda-logo-light')) ? 'images/brand/musheeda-logo-dark.svg' : null;
    @endphp
    <body class="font-sans text-slate-900 antialiased">
        <div class="grid min-h-screen lg:grid-cols-2">
            <!-- Brand panel -->
            <aside class="relative hidden flex-col justify-between overflow-hidden bg-slate-950 p-12 text-white lg:flex">
                <div class="bg-grid-light pointer-events-none absolute inset-0 [mask-image:radial-gradient(ellipse_at_bottom_left,black,transparent_70%)]" aria-hidden="true"></div>
                <a href="/" class="relative flex items-center gap-2.5">
                    @if($logo)
                        <img src="{{ asset($logo) }}" alt="{{ $siteName }}" class="h-11 w-auto max-w-[260px] object-contain">
                    @else
                        <span class="grid h-8 w-8 place-items-center rounded-md bg-white font-display text-lg leading-none text-slate-950">{{ mb_substr($siteName, 0, 1) }}</span>
                        <span class="text-[17px] font-semibold tracking-tight">{{ $siteName }}</span>
                    @endif
                </a>
                <p class="relative max-w-md font-display text-5xl leading-[1.05] tracking-tight">
                    Everything your website needs, <em class="text-brand-300">in one quiet place.</em>
                </p>
                <p class="relative text-xs text-slate-500">&copy; {{ date('Y') }} {{ $siteName }}</p>
            </aside>

            <!-- Form -->
            <main class="flex flex-col items-center justify-center bg-slate-50 px-6 py-16">
                <a href="/" class="mb-10 flex items-center gap-2.5 lg:hidden">
                    @if($logoOnLight)
                        <img src="{{ asset($logoOnLight) }}" alt="{{ $siteName }}" class="h-10 w-auto max-w-[240px] object-contain">
                    @elseif($logo)
                        <span class="inline-flex items-center rounded-xl bg-slate-950 px-4 py-2.5">
                            <img src="{{ asset($logo) }}" alt="{{ $siteName }}" class="h-8 w-auto max-w-[200px] object-contain">
                        </span>
                    @else
                        <span class="grid h-8 w-8 place-items-center rounded-md bg-slate-900 font-display text-lg leading-none text-white">{{ mb_substr($siteName, 0, 1) }}</span>
                        <span class="text-[17px] font-semibold tracking-tight">{{ $siteName }}</span>
                    @endif
                </a>
                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
