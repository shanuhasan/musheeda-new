@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">
        Edit Product
    </h2>
    <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-brand-500 hover:text-brand-600">
        &larr; Back to Products
    </a>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST">
    @csrf
    @method('PUT')
    @include('admin.products.form')
</form>
@endsection
