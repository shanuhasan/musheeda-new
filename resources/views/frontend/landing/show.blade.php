<x-app-layout>
    <div class="landing-page">
        @if(request()->query('preview') === 'true')
            <div class="bg-amber-50 border-b border-amber-200 px-4 py-3 text-center text-sm font-semibold text-amber-800 relative z-50">
                You are viewing this landing page in PREVIEW mode. Status: {{ strtoupper($landingPage->status) }}
            </div>
        @endif

        @if($landingPage->blocks && is_array($landingPage->blocks))
            @foreach($landingPage->blocks as $block)
                @if(view()->exists('frontend.landing.blocks.' . $block['type']))
                    @include('frontend.landing.blocks.' . $block['type'], ['data' => $block['data']])
                @else
                    @if(config('app.debug'))
                        <div class="p-4 bg-red-100 text-red-800 text-center border border-red-200">
                            Block type <strong>{{ $block['type'] }}</strong> not found.
                        </div>
                    @endif
                @endif
            @endforeach
        @else
            <div class="min-h-[50vh] flex items-center justify-center text-gray-500">
                No content blocks added to this landing page yet.
            </div>
        @endif
    </div>
</x-app-layout>
