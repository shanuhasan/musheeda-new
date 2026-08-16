@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">
        Add Service
    </h2>
    <a href="{{ route('admin.services.index') }}" class="text-sm font-medium text-brand-500 hover:text-brand-600">
        &larr; Back to Services
    </a>
</div>

<form action="{{ route('admin.services.store') }}" method="POST">
    @csrf
    @include('admin.services.form')
</form>
@endsection
