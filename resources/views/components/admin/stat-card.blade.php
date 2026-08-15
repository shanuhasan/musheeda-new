@props(['title', 'value', 'icon', 'color' => 'indigo'])

<div class="rounded-2xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-white/[0.03] md:p-6 transition-transform hover:-translate-y-1 hover:shadow-sm">
    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-{{ $color }}-500">
        {!! $icon !!}
    </div>
    
    <div class="mt-5 flex items-end justify-between">
      <div>
        <span class="text-sm text-slate-500 dark:text-slate-400">{{ $title }}</span>
        <h4 class="mt-2 text-2xl font-bold text-slate-800 dark:text-white/90">
          {{ $value }}
        </h4>
      </div>
    </div>
</div>
