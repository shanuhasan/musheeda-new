@props(['title', 'items' => [], 'emptyMessage' => 'No items found.'])

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
    <div class="mb-4 flex items-center justify-between">
        <h4 class="text-xl font-bold text-slate-800 dark:text-white/90">{{ $title }}</h4>
        {{ $action ?? '' }}
    </div>
    
    <div class="flex flex-col gap-2">
        {{ $slot }}
    </div>
</div>
