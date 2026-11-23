@props(['title', 'value', 'icon' => null, 'color' => 'brand', 'href' => null, 'hint' => null])

@php
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }} @if($href) href="{{ $href }}" @endif class="group relative flex flex-col justify-between bg-white p-5 transition-colors dark:bg-slate-900 md:p-6 {{ $href ? 'hover:bg-slate-50 dark:hover:bg-slate-800/60' : '' }}">
    <div class="flex items-center justify-between gap-3">
        <span class="text-[13px] font-medium text-slate-500 dark:text-slate-400">{{ $title }}</span>
        @if($icon)
            <span class="text-slate-300 transition-colors group-hover:text-slate-500 dark:text-slate-600 [&>svg]:h-[18px] [&>svg]:w-[18px]">{!! $icon !!}</span>
        @endif
    </div>
    <div class="mt-6 flex items-end justify-between gap-3">
        <span class="text-[32px] font-semibold leading-none tracking-tight text-slate-900 tabular-nums dark:text-white">{{ $value }}</span>
        @if($hint)
            <span class="text-xs text-slate-500">{{ $hint }}</span>
        @endif
    </div>
</{{ $tag }}>
