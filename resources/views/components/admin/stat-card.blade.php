@props(['title', 'value', 'icon', 'color' => 'indigo'])

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center transition-all duration-200 hover:shadow-md hover:-translate-y-1">
    <div class="p-3 rounded-lg bg-{{ $color }}-50 text-{{ $color }}-600 mr-4">
        {!! $icon !!}
    </div>
    <div>
        <p class="text-sm font-medium text-gray-500 mb-1">{{ $title }}</p>
        <p class="text-2xl font-bold text-gray-900">{{ $value }}</p>
    </div>
</div>
