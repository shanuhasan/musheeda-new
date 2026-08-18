<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
    @php
        $ads = \App\Models\Advertisement::where('placement', $placement)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
    @endphp

    @if($ads->count() > 0)
        <div class="ad-container my-8 w-full flex justify-center {{ $class ?? '' }}">
            @foreach($ads as $ad)
                <div class="ad-slot relative" style="min-height: 90px; min-width: 320px;">
                    @if($ad->is_lazy)
                        <div x-data="{ loaded: false }" 
                             x-intersect.once="loaded = true" 
                             class="w-full h-full flex items-center justify-center bg-slate-50 dark:bg-slate-800/50 rounded text-slate-400 text-sm">
                            <template x-if="loaded">
                                <div>
                                    {!! $ad->code !!}
                                </div>
                            </template>
                            <span x-show="!loaded">Advertisement</span>
                        </div>
                    @else
                        {!! $ad->code !!}
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>