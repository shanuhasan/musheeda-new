<!-- Features Block -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(!empty($data['title']))
            <div class="text-center mb-16">
                <h2 class="text-3xl font-extrabold text-slate-900 sm:text-4xl">
                    {{ $data['title'] }}
                </h2>
                <div class="mt-4 h-1 w-20 bg-brand-500 mx-auto rounded-full"></div>
            </div>
        @endif

        @if(!empty($data['items']) && is_array($data['items']))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($data['items'] as $item)
                    <div class="bg-slate-50 rounded-2xl p-8 border border-slate-100 hover:shadow-lg hover:border-brand-100 transition-all group">
                        <div class="w-12 h-12 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-brand-600 group-hover:text-white transition-all">
                            <!-- Generic Icon, since we didn't add icon picking to the builder to keep it simple, or user can add HTML in title? We'll just use a checkmark for now -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $item['title'] ?? '' }}</h3>
                        <p class="text-slate-600 leading-relaxed">
                            {{ $item['description'] ?? '' }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
