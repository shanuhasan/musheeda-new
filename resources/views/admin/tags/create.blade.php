@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">Create Tag</h2>
</div>

<form action="{{ route('admin.tags.store') }}" method="POST" class="max-w-2xl">
    @csrf
    
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6 space-y-5">
        <div>
            <label for="name" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
            @error('name') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="slug" class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Slug (Optional)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
            @error('slug') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-2 text-center font-medium text-white hover:bg-brand-600">
            Save Tag
        </button>
    </div>
</form>
@endsection
