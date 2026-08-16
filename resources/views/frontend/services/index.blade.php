<x-app-layout>
    <x-seo />

    <!-- Hero Section -->
    <section class="bg-brand-900 text-white py-20 lg:py-32">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Our Services</h1>
            <p class="text-xl text-brand-100 max-w-2xl mx-auto">
                Comprehensive software solutions tailored to streamline your operations and drive growth.
            </p>
        </div>
    </section>

    <!-- Services List -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($services as $service)
                    <a href="{{ url('/services/' . $service->slug) }}" class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                        @if($service->featured_image)
                            <div class="h-48 w-full bg-gray-200 overflow-hidden relative">
                                <img src="{{ $service->featured_image }}" alt="{{ $service->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            </div>
                        @else
                            <div class="h-48 w-full bg-brand-50 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-brand-500 to-transparent"></div>
                                @if($service->icon)
                                    <span class="text-5xl text-brand-500 relative z-10">{{ $service->icon }}</span>
                                @else
                                    <svg class="w-16 h-16 text-brand-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                @endif
                            </div>
                        @endif
                        
                        <div class="p-8 flex flex-col flex-grow">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-brand-600 transition-colors">{{ $service->name }}</h2>
                            <p class="text-gray-600 mb-6 flex-grow line-clamp-3">
                                {{ $service->short_description ?? Str::limit(strip_tags($service->full_description), 120) }}
                            </p>
                            
                            <div class="flex items-center text-brand-600 font-semibold group-hover:translate-x-2 transition-transform duration-300 mt-auto">
                                Learn more
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500">
                        <p>No services found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>
