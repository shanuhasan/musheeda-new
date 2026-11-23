{{-- Favicon for admin and auth screens: the site favicon from Settings, or the brand mark as a fallback. --}}
@php $favicon = setting('favicon') ? asset(setting('favicon')) : asset('images/brand/musheeda-mark.svg'); @endphp
<link rel="icon" href="{{ $favicon }}">
<link rel="shortcut icon" href="{{ $favicon }}">
<link rel="apple-touch-icon" href="{{ $favicon }}">
