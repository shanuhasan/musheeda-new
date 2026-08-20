<x-app-layout>
    <x-seo />

    <!-- Hero Section -->
    <section class="bg-brand-900 text-white py-20 lg:py-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-800/50 to-transparent"></div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Our Products</h1>
            <p class="text-xl text-brand-100 max-w-2xl mx-auto">
                Powerful, scalable software products designed to take your business to the next level.
            </p>
        </div>
    </section>

    <!-- Products List -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($products as $product)
                    <div class="bg-white rounded-3xl shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 overflow-hidden flex flex-col h-full group relative">
                        
                        @if($product->status == 'discontinued')
                            <div class="absolute top-4 right-4 z-20">
                                <span class="bg-error-100 text-error-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Discontinued</span>
                            </div>
                        @endif

                        @php
                            $imageUrl = null;
                            if (is_array($product->images) && count($product->images) > 0) {
                                $imageUrl = $product->images[0];
                            }
                        @endphp
                        
                        @if($imageUrl)
                            <div class="h-56 w-full overflow-hidden relative">
                                <img src="{{ asset($imageUrl) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                        @else
                            <div class="h-56 w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative overflow-hidden">
                                <svg class="w-20 h-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                        @endif
                        
                        <div class="p-8 flex flex-col flex-grow">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $product->name }}</h2>
                            <p class="text-gray-600 mb-6 flex-grow line-clamp-3">
                                {{ $product->short_description ?? Str::limit(strip_tags($product->description), 120) }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-100">
                                @if($product->price)
                                    <div>
                                        <span class="text-lg font-bold text-gray-900">₹{{ number_format($product->price, 2) }}</span>
                                        @if($product->pricing_type)
                                            <span class="text-sm text-gray-500 capitalize">/ {{ $product->pricing_type }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-brand-600 font-semibold">Custom Pricing</span>
                                @endif
                                
                                <a href="{{ url('/products/' . $product->slug) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 hover:bg-brand-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p>No products found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>
