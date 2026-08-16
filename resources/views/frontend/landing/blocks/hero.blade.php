<!-- Hero Block -->
<section class="relative bg-white py-20 overflow-hidden lg:py-32">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 bg-brand-50/50 -z-10" style="clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-brand-200/40 blur-3xl -z-10"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
            
            <div class="lg:col-span-6 text-center lg:text-left">
                @if(!empty($data['heading']))
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight mb-6">
                        {{ $data['heading'] }}
                    </h1>
                @endif
                
                @if(!empty($data['subheading']))
                    <p class="text-lg md:text-xl text-slate-600 mb-8 max-w-2xl mx-auto lg:mx-0">
                        {{ $data['subheading'] }}
                    </p>
                @endif
                
                @if(!empty($data['button_text']) && !empty($data['button_url']))
                    <div class="flex justify-center lg:justify-start">
                        <a href="{{ $data['button_url'] }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-white bg-brand-600 hover:bg-brand-700 shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1">
                            {{ $data['button_text'] }}
                        </a>
                    </div>
                @endif
            </div>
            
            @if(!empty($data['image_url']))
            <div class="lg:col-span-6 mt-12 lg:mt-0 relative">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white transform hover:-translate-y-2 transition-transform duration-500">
                    <img src="{{ $data['image_url'] }}" alt="{{ $data['heading'] ?? 'Hero Image' }}" class="w-full h-auto object-cover">
                </div>
            </div>
            @endif
            
        </div>
    </div>
</section>
