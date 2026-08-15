@props(['title', 'items' => [], 'emptyMessage' => 'No items found.'])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
        <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        {{ $action ?? '' }}
    </div>
    
    <div class="divide-y divide-gray-100">
        {{ $slot }}
    </div>
</div>
