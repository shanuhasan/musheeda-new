<x-app-layout>
    <x-seo />

    @if($product->status == 'discontinued')
        <div class="bg-error-50 border-b border-error-100 text-error-700 py-3 px-4 text-center text-sm font-medium">
            This product has been discontinued and is no longer available for purchase. Information is provided for reference only.
        </div>
    @endif

    <!-- Product Header -->
    <section class="bg-white py-12 md:py-20 border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                
                <!-- Images Slider (Simplified for now) -->
                <div class="order-2 lg:order-1">
                    @php
                        $images = is_array($product->images) ? $product->images : [];
                    @endphp
                    
                    @if(count($images) > 0)
                        <div x-data="{ activeImage: '{{ asset($images[0]) }}' }">
                            <div class="rounded-3xl overflow-hidden shadow-2xl shadow-gray-200/50 border border-gray-100 bg-gray-50 aspect-video flex items-center justify-center relative group">
                                <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                
                                @if(count($images) > 1)
                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                                        @foreach($images as $idx => $img)
                                            <div class="w-2.5 h-2.5 rounded-full shadow cursor-pointer" :class="activeImage === '{{ asset($img) }}' ? 'bg-white' : 'bg-white/50'" @click="activeImage = '{{ asset($img) }}'"></div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            
                            @if(count($images) > 1)
                                <div class="flex gap-4 mt-4 overflow-x-auto pb-2 snap-x">
                                    @foreach($images as $idx => $img)
                                        <div @click="activeImage = '{{ asset($img) }}'" class="w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border-2 cursor-pointer snap-start transition-colors duration-200" :class="activeImage === '{{ asset($img) }}' ? 'border-brand-500' : 'border-transparent'">
                                            <img src="{{ asset($img) }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="rounded-3xl shadow-lg border border-gray-100 bg-gray-50 aspect-video flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    @endif
                </div>
                
                <!-- Product Info -->
                <div class="order-1 lg:order-2 space-y-8">
                    <div>
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4 tracking-tight">{{ $product->name }}</h1>
                        @if($product->short_description)
                            <p class="text-xl text-gray-600 leading-relaxed">{{ $product->short_description }}</p>
                        @endif
                    </div>
                    
                    <!-- Pricing & CTA -->
                    <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100">
                        <div class="flex items-end gap-3 mb-6">
                            @if($product->price)
                                <span class="text-4xl font-black text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                                @if($product->pricing_type)
                                    <span class="text-lg text-gray-500 mb-1 capitalize">/ {{ $product->pricing_type }}</span>
                                @endif
                            @else
                                <span class="text-2xl font-bold text-gray-900">Contact for pricing</span>
                            @endif
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            @php
                                $cta = is_array($product->cta) ? $product->cta : [];
                                $ctaUrl = $cta['url'] ?? '/contact';
                                $ctaText = $cta['title'] ?? 'Get Started';
                            @endphp
                            
                            @if($product->status != 'discontinued')
                                <a href="{{ $ctaUrl }}" class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl shadow-lg shadow-brand-500/30 transition-all transform hover:-translate-y-0.5">
                                    {{ $ctaText }}
                                </a>
                            @endif
                            
                            @if($product->demo_url)
                                <a href="{{ $product->demo_url }}" target="_blank" class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-900 border border-gray-200 font-bold rounded-xl transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Live Demo
                                </a>
                            @endif
                        </div>
                        
                        @if($product->documentation_url)
                            <div class="mt-6 text-center sm:text-left">
                                <a href="{{ $product->documentation_url }}" target="_blank" class="text-sm font-medium text-brand-600 hover:text-brand-700 inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    View Documentation
                                </a>
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <!-- Content Sections -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <div class="lg:col-span-8 space-y-16">
                    <!-- Description -->
                    @if($product->description)
                        <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">Overview</h2>
                            <div class="prose prose-lg prose-brand max-w-none">
                                {!! $product->description !!}
                            </div>
                        </div>
                    @endif

                    <!-- Lead Form in Content Area -->
                    <div class="mt-12">
                        <x-lead-form 
                            source="product" 
                            product-service="{{ $product->name }}" 
                            title="Inquire About {{ $product->name }}" 
                            button-text="Send Inquiry"
                        />
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8">
                    
                    @if(is_array($product->features) && count($product->features) > 0)
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Product Features</h3>
                            <ul class="space-y-4">
                                @foreach($product->features as $feature)
                                    <li class="flex items-start">
                                        <div class="flex-shrink-0 w-6 h-6 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 mr-3 mt-0.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <span class="text-gray-700">{{ is_array($feature) ? ($feature['title'] ?? json_encode($feature)) : $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(is_array($product->benefits) && count($product->benefits) > 0)
                        <div class="bg-gray-900 text-white p-8 rounded-3xl shadow-lg">
                            <h3 class="text-xl font-bold mb-6">Business Benefits</h3>
                            <ul class="space-y-4">
                                @foreach($product->benefits as $benefit)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-brand-400 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-gray-300 text-sm leading-relaxed">{{ is_array($benefit) ? ($benefit['title'] ?? json_encode($benefit)) : $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                </div>
                
            </div>
        </div>
    </section>
</x-app-layout>
