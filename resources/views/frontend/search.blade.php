@extends('layouts.app')

@section('title', 'Search Results' . ($query ? ' for "' . $query . '"' : ''))

@section('content')
<div class="bg-white dark:bg-slate-900 py-16 sm:py-24">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-5xl mb-4">
                Search Results
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                @if($query)
                    Found {{ $results->total() }} result(s) for "<span class="font-bold text-slate-900 dark:text-white">{{ $query }}</span>"
                @else
                    Enter a search term below to find what you're looking for.
                @endif
            </p>
        </div>

        <div class="max-w-3xl mx-auto mb-16">
            <!-- Search Form -->
            <form action="{{ route('search') }}" method="GET" class="relative flex items-center mb-8">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="q" value="{{ request('q') }}" class="block w-full p-5 pl-12 text-lg text-slate-900 border border-slate-300 rounded-2xl bg-slate-50 focus:ring-brand-500 focus:border-brand-500 dark:bg-slate-800 dark:border-slate-700 dark:placeholder-slate-400 dark:text-white dark:focus:ring-brand-500 dark:focus:border-brand-500 shadow-sm transition-all" placeholder="Search pages, posts, products, services..." required>
                @if($type)
                    <input type="hidden" name="type" value="{{ $type }}">
                @endif
                <button type="submit" class="text-white absolute right-3 bottom-3 top-3 bg-brand-600 hover:bg-brand-700 focus:ring-4 focus:outline-none focus:ring-brand-300 font-bold rounded-xl text-base px-6 py-2 shadow-md shadow-brand-500/20 transition-all">Search</button>
            </form>

            @if($query)
            <!-- Filters -->
            <div class="flex flex-wrap gap-2 justify-center mb-10">
                <a href="{{ route('search', ['q' => $query]) }}" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ is_null($type) ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    All
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'page']) }}" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ $type === 'page' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Pages
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'post']) }}" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ $type === 'post' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Blog Posts
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'product']) }}" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ $type === 'product' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Products
                </a>
                <a href="{{ route('search', ['q' => $query, 'type' => 'service']) }}" class="px-4 py-2 rounded-full text-sm font-semibold transition-colors {{ $type === 'service' ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-900' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    Services
                </a>
            </div>
            @endif

            <!-- Results List -->
            @if($query && $results->count() > 0)
                <div class="space-y-6">
                    @foreach($results as $result)
                        <article class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow group">
                            <div class="flex items-center gap-3 mb-3">
                                @php
                                    $badgeColor = match($result->type) {
                                        'post' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400',
                                        'page' => 'bg-slate-100 text-slate-700 dark:bg-slate-500/20 dark:text-slate-400',
                                        'product' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                        'service' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400',
                                        default => 'bg-slate-100 text-slate-700'
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-bold uppercase tracking-wider {{ $badgeColor }}">
                                    {{ $result->type }}
                                </span>
                                @if($result->date)
                                <time class="text-sm text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($result->date)->format('M d, Y') }}</time>
                                @endif
                            </div>
                            
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-brand-600 dark:group-hover:text-brand-400 transition-colors">
                                <a href="{{ $result->url }}">
                                    {{ $result->title }}
                                </a>
                            </h2>
                            
                            @if($result->excerpt)
                                <p class="text-slate-600 dark:text-slate-300 line-clamp-3">
                                    {{ strip_tags($result->excerpt) }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>
                
                <div class="mt-10">
                    {{ $results->links() }}
                </div>
            @elseif($query)
                <div class="text-center py-16 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-200 dark:border-slate-700">
                    <svg class="mx-auto h-16 w-16 text-slate-400 dark:text-slate-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No results found</h3>
                    <p class="text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                        We couldn't find anything matching your search term. Try adjusting your keywords or browse our categories.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
