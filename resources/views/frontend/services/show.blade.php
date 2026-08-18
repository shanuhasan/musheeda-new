<x-app-layout>
    <x-seo />

    <!-- Hero Section -->
    <section class="relative bg-brand-900 text-white py-24 lg:py-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-brand-600 blur-3xl opacity-20"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-brand-500 blur-3xl opacity-20"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            @if($service->icon)
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-brand-800 border border-brand-700 text-brand-300 mb-8 shadow-inner shadow-brand-500/20 text-4xl">
                    {{ $service->icon }}
                </div>
            @endif
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 tracking-tight">{{ $service->name }}</h1>
            
            @if($service->short_description)
                <p class="text-xl text-brand-100 max-w-3xl mx-auto leading-relaxed">
                    {{ $service->short_description }}
                </p>
            @endif
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-start">
                
                <!-- Content Area -->
                <div class="lg:col-span-8 space-y-16">
                    
                    @if($service->full_description)
                        <div class="prose prose-lg prose-brand max-w-none bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">
                            {!! $service->full_description !!}
                        </div>
                    @endif

                    @if(is_array($service->features) && count($service->features) > 0)
                        <div class="bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100">
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">Key Features</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($service->features as $feature)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 mr-4">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <p class="text-gray-700 font-medium pt-2">{{ is_array($feature) ? ($feature['title'] ?? json_encode($feature)) : $feature }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(is_array($service->faq) && count($service->faq) > 0)
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-8">Frequently Asked Questions</h2>
                            <div class="space-y-4" x-data="{ activeFaq: null }">
                                @foreach($service->faq as $index => $item)
                                    @php 
                                        $q = is_array($item) ? ($item['question'] ?? '') : '';
                                        $a = is_array($item) ? ($item['answer'] ?? '') : '';
                                    @endphp
                                    @if($q && $a)
                                    <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                                        <button @click="activeFaq = activeFaq === {{ $index }} ? null : {{ $index }}" class="flex items-center justify-between w-full p-6 text-left focus:outline-none">
                                            <span class="text-lg font-semibold text-gray-900" :class="activeFaq === {{ $index }} ? 'text-brand-600' : ''">{{ $q }}</span>
                                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-300" :class="activeFaq === {{ $index }} ? 'rotate-180 text-brand-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>
                                        <div x-show="activeFaq === {{ $index }}" x-collapse class="px-6 pb-6 text-gray-600 leading-relaxed">
                                            {{ $a }}
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Lead Form in Content Area -->
                <div class="lg:col-span-8 mt-12">
                    <x-lead-form 
                        source="service" 
                        product-service="{{ $service->name }}" 
                        title="Inquire About {{ $service->name }}" 
                        button-text="Send Inquiry"
                    />
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-8 sticky top-24">
                    
                    @if($service->featured_image)
                        <div class="rounded-3xl overflow-hidden shadow-xl shadow-gray-200/50">
                            <img src="{{ $service->featured_image }}" alt="{{ $service->name }}" class="w-full h-auto">
                        </div>
                    @endif

                    @if(is_array($service->benefits) && count($service->benefits) > 0)
                        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl p-8 text-white shadow-xl shadow-gray-900/10">
                            <h3 class="text-2xl font-bold mb-6">Why Choose Us</h3>
                            <ul class="space-y-4">
                                @foreach($service->benefits as $benefit)
                                    <li class="flex items-start">
                                        <svg class="w-6 h-6 text-brand-400 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <span class="text-gray-300 font-medium leading-tight pt-1">{{ is_array($benefit) ? ($benefit['title'] ?? json_encode($benefit)) : $benefit }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @php
                        $cta = is_array($service->cta) ? $service->cta : [];
                        $ctaTitle = $cta['title'] ?? 'Ready to get started?';
                        $ctaUrl = $cta['url'] ?? '/contact';
                        $ctaText = $cta['text'] ?? 'Contact Us Today';
                    @endphp
                    <div class="bg-brand-50 rounded-3xl p-8 text-center border border-brand-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $ctaTitle }}</h3>
                        <p class="text-gray-600 mb-8">Get in touch with our experts to discuss how we can help your business.</p>
                        <a href="{{ $ctaUrl }}" class="inline-flex items-center justify-center w-full py-4 px-8 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700 transform hover:-translate-y-1 transition-all shadow-lg shadow-brand-500/30">
                            {{ $ctaText }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
