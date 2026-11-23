@props(['title', 'items' => [], 'emptyMessage' => 'No items found.'])

<section class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
    <header class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
        <h3 class="text-[14px] font-semibold text-slate-900 dark:text-white">{{ $title }}</h3>
        {{ $action ?? '' }}
    </header>

    <div class="divide-y divide-slate-100 dark:divide-slate-800">
        {{ $slot }}
    </div>
</section>
