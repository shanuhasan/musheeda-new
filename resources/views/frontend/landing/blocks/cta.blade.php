<!-- CTA Block -->
<section class="py-20 bg-brand-900 text-white relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-50"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-brand-600/30 rounded-full blur-3xl"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        @if(!empty($data['heading']))
            <h2 class="text-3xl md:text-5xl font-extrabold mb-6">
                {{ $data['heading'] }}
            </h2>
        @endif
        
        @if(!empty($data['text']))
            <p class="text-lg md:text-xl text-brand-100 mb-10 max-w-2xl mx-auto">
                {{ $data['text'] }}
            </p>
        @endif
        
        @if(!empty($data['button_text']) && !empty($data['button_url']))
            <a href="{{ $data['button_url'] }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-brand-900 bg-white hover:bg-gray-50 shadow-xl transition-all hover:-translate-y-1">
                {{ $data['button_text'] }}
            </a>
        @endif
    </div>
</section>
