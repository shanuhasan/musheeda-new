<x-app-layout>
    <!-- Hero Section -->
    <section class="relative pt-24 pb-32 lg:pt-36 lg:pb-40 overflow-hidden bg-white">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-brand-100/40 via-white to-white -z-10"></div>
        
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] rounded-full bg-brand-200/30 blur-3xl -z-10 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] rounded-full bg-blue-200/30 blur-3xl -z-10" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center max-w-4xl mx-auto" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <span class="inline-block py-1 px-3 rounded-full bg-brand-50 text-brand-600 text-sm font-semibold mb-6 shadow-sm border border-brand-100 transition-all duration-700 transform" :class="show ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                    Welcome to {{ setting('site_name', 'Musheeda Solutions') }}
                </span>
                
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 leading-tight transition-all duration-700 delay-100 transform" :class="show ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                    Empowering your business with <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-blue-600">cutting-edge software</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-slate-600 mb-10 max-w-2xl mx-auto transition-all duration-700 delay-200 transform" :class="show ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                    {{ setting('footer_about', 'We build custom software, ERPs, CRMs, and robust web applications designed to streamline your workflow and drive growth.') }}
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4 transition-all duration-700 delay-300 transform" :class="show ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                    <a href="{{ setting('header_cta_url', '/contact') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-white bg-brand-600 hover:bg-brand-700 shadow-lg shadow-brand-500/30 transition-all transform hover:-translate-y-1">
                        {{ setting('header_cta_text', 'Start a Project') }}
                    </a>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold rounded-xl text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 shadow-sm transition-all transform hover:-translate-y-1">
                        Explore Our Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    @if($services->count() > 0)
    <section class="py-16 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-brand-600 font-semibold tracking-wide uppercase">Our Expertise</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">Specialized IT Services</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service->slug) }}" class="group relative bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full">
                        <div class="h-2 bg-gradient-to-r from-brand-500 to-blue-500 w-0 group-hover:w-full transition-all duration-500 absolute top-0 left-0"></div>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="w-14 h-14 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center mb-6 text-2xl shadow-sm border border-brand-100 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300">
                                @if($service->icon)
                                    {{ $service->icon }}
                                @else
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">{{ $service->name }}</h3>
                            <p class="text-slate-600 mb-6 flex-grow line-clamp-3">
                                {{ $service->short_description ?? Str::limit(strip_tags($service->full_description), 120) }}
                            </p>
                            <span class="inline-flex items-center py-2 text-brand-600 font-semibold group-hover:translate-x-2 transition-transform duration-300 mt-auto">
                                Learn more
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-12 text-center">
                <a href="{{ route('services.index') }}" class="inline-flex items-center text-slate-600 hover:text-brand-600 font-semibold transition-colors">
                    View all services
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Products Section (Dark Theme) -->
    @if($products->count() > 0)
    <section class="py-16 md:py-24 bg-slate-900 text-white relative overflow-hidden">
        <!-- Background decorative elements -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-50"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-600 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-600 rounded-full blur-3xl opacity-20"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-base text-brand-400 font-semibold tracking-wide uppercase">Software Solutions</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl">Products built for scale</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($products as $product)
                    @php
                        $imageUrl = null;
                        if (is_array($product->images) && count($product->images) > 0) {
                            $imageUrl = $product->images[0];
                        }
                    @endphp
                    <a href="{{ $product->demo_url ?? route('products.show', $product->slug) }}" target="{{ $product->demo_url ? '_blank' : '_self' }}" class="bg-slate-800/50 backdrop-blur-sm border border-slate-700/50 rounded-2xl overflow-hidden hover:border-brand-500/50 transition-colors duration-300 flex flex-col h-full group block cursor-pointer">
                        @if($imageUrl)
                            <div class="h-48 overflow-hidden relative">
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-60"></div>
                            </div>
                        @else
                            <div class="h-48 bg-slate-800 flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                        @endif
                        <div class="p-8 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                            <p class="text-slate-400 mb-6 flex-grow line-clamp-3">
                                {{ $product->short_description ?? Str::limit(strip_tags($product->description), 120) }}
                            </p>
                            <div class="flex items-center justify-between mt-auto">
                                @if($product->price)
                                    <span class="text-lg font-bold text-white">₹{{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="text-brand-400 font-medium">Custom</span>
                                @endif
                                <span class="px-4 py-3 sm:py-2 bg-slate-700 group-hover:bg-brand-600 text-white text-sm font-semibold rounded-lg transition-colors inline-flex items-center justify-center">
                                    View Details
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-12 text-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-slate-400 hover:text-brand-400 font-semibold transition-colors">
                    Explore all products
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Blog Section -->
    @if($posts->count() > 0)
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-base text-brand-600 font-semibold tracking-wide uppercase">Our Blog</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">Latest Insights</p>
                </div>
                <div class="hidden sm:block">
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center text-brand-600 hover:text-brand-700 font-semibold transition-colors">
                        Read the blog
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="flex flex-col rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if($post->hasMedia('featured_image'))
                            <div class="h-48 w-full overflow-hidden">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    <img src="{{ $post->getFirstMediaUrl('featured_image', 'thumb') }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                </a>
                            </div>
                        @endif
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center gap-2 mb-3">
                                @if($post->categories->count() > 0)
                                    <span class="text-xs font-semibold text-brand-600 uppercase tracking-wider">{{ $post->categories->first()->name }}</span>
                                    <span class="text-slate-300">&bull;</span>
                                @endif
                                <span class="text-xs text-slate-500">{{ $post->published_at->format('M d, Y') }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2 hover:text-brand-600 transition-colors">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="text-slate-600 flex-grow line-clamp-3 mb-4">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            
                            <div class="mt-auto flex items-center pt-4 border-t border-slate-50">
                                <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs mr-3">
                                    {{ substr($post->author->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-slate-900">{{ $post->author->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-16 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-brand-600"></div>
        <!-- Decorative SVG -->
        <svg class="absolute top-0 right-0 transform translate-x-1/3 -translate-y-1/4 text-brand-500 opacity-50" width="404" height="404" fill="none" viewBox="0 0 404 404" aria-hidden="true">
            <defs>
                <pattern id="cta-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <rect x="0" y="0" width="4" height="4" fill="currentColor" />
                </pattern>
            </defs>
            <rect width="404" height="404" fill="url(#cta-pattern)" />
        </svg>
        
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-6">Ready to transform your business?</h2>
            <p class="text-xl text-brand-100 mb-10 max-w-3xl mx-auto">
                Join hundreds of satisfied clients who have scaled their operations with our custom solutions. Let's discuss your project today.
            </p>
            <a href="{{ setting('header_cta_url', '/contact') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold rounded-xl text-brand-600 bg-white hover:bg-slate-50 shadow-xl transition-transform transform hover:-translate-y-1">
                {{ setting('header_cta_text', 'Contact Us Now') }}
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </section>
</x-app-layout>
