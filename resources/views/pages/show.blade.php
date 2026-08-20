<x-app-layout>
    @if(request()->query('preview') === 'true')
    <div class="bg-amber-50 border-b border-amber-200 px-4 py-3 text-center text-sm font-semibold text-amber-800">
        You are viewing this page in PREVIEW mode. Status: {{ strtoupper($page->status) }}
    </div>
    @endif

    <!-- Hero Section -->
    <div class="relative bg-brand-900 pt-16 pb-20 sm:pt-24 sm:pb-32 overflow-hidden border-b border-brand-800 text-white">
        <!-- Decorative blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[500px] h-[500px] rounded-full bg-brand-600/30 blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] rounded-full bg-blue-600/30 blur-3xl -z-10"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6">
                {{ $page->title }}
            </h1>
            
            @if($page->author && $page->published_at)
            <div class="mt-8 flex items-center justify-center gap-3 text-sm text-brand-100 font-medium">
                <div class="w-8 h-8 rounded-full bg-brand-800 text-brand-100 flex items-center justify-center font-bold text-xs">
                    {{ substr($page->author->name, 0, 1) }}
                </div>
                <div class="text-white">{{ $page->author->name }}</div>
                <span class="text-brand-300">&bull;</span>
                <time datetime="{{ $page->published_at->toIso8601String() }}">{{ $page->published_at->format('F d, Y') }}</time>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white pb-24 relative z-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 sm:-mt-16">
            
            <!-- Featured Image -->
            @if($page->hasMedia('featured_image'))
            <div class="mb-16 rounded-2xl shadow-xl border-4 border-white overflow-hidden bg-white">
                <img class="w-full h-auto max-h-[600px] object-cover" src="{{ $page->getFirstMediaUrl('featured_image') }}" alt="{{ $page->title }}">
            </div>
            @else
            <div class="h-10 sm:h-16"></div> <!-- Spacing if no image -->
            @endif

            <!-- Content Area -->
            <div class="prose prose-lg prose-slate prose-a:text-brand-600 hover:prose-a:text-brand-700 mx-auto bg-white rounded-2xl md:p-12 shadow-sm border border-slate-100">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-app-layout>
