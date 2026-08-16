<!-- Image + Text Block -->
@php
    $imagePos = $data['image_position'] ?? 'left';
@endphp
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
            
            <!-- Image Area -->
            <div class="{{ $imagePos === 'right' ? 'lg:order-2' : 'lg:order-1' }} mb-10 lg:mb-0">
                @if(!empty($data['image_url']))
                    <div class="rounded-2xl overflow-hidden shadow-xl">
                        <img src="{{ $data['image_url'] }}" alt="{{ $data['heading'] ?? 'Image' }}" class="w-full h-auto object-cover">
                    </div>
                @else
                    <div class="rounded-2xl bg-slate-200 aspect-video flex items-center justify-center text-slate-400 shadow-inner">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                @endif
            </div>

            <!-- Text Area -->
            <div class="{{ $imagePos === 'right' ? 'lg:order-1' : 'lg:order-2' }}">
                @if(!empty($data['heading']))
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-6">{{ $data['heading'] }}</h2>
                @endif
                
                @if(!empty($data['text']))
                    <div class="prose prose-lg text-slate-600">
                        {!! nl2br(e($data['text'])) !!}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</section>
