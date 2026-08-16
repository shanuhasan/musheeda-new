@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">
        Edit Redirect
    </h2>
    <a href="{{ route('admin.redirects.index') }}" class="text-sm font-medium text-brand-500 hover:text-brand-600">
        &larr; Back to Redirects
    </a>
</div>

<form action="{{ route('admin.redirects.update', $redirect) }}" method="POST" class="max-w-2xl">
    @csrf
    @method('PUT')
    
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6 space-y-6">
        
        <div>
            <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Old URL <span class="text-error-500">*</span></label>
            <div class="flex items-center">
                <span class="rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 py-3 text-slate-500 dark:border-slate-700 dark:bg-slate-800">/</span>
                <input type="text" name="old_url" value="{{ old('old_url', $redirect->old_url) }}" required placeholder="old-page-path" class="w-full rounded-r-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
            </div>
            <p class="mt-1 text-xs text-slate-500">The path you want to redirect from (without the domain).</p>
            @error('old_url') <span class="text-sm text-error-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div x-data="{ status: '{{ old('status_code', $redirect->status_code) }}' }">
            <div class="mb-6">
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Redirect Type <span class="text-error-500">*</span></label>
                <select name="status_code" x-model="status" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                    <option value="301" {{ old('status_code', $redirect->status_code) == 301 ? 'selected' : '' }}>301 - Permanent (Best for SEO)</option>
                    <option value="302" {{ old('status_code', $redirect->status_code) == 302 ? 'selected' : '' }}>302 - Temporary</option>
                    <option value="410" {{ old('status_code', $redirect->status_code) == 410 ? 'selected' : '' }}>410 - Content Deleted (Gone)</option>
                </select>
            </div>

            <div x-show="status !== '410'">
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">New URL <span class="text-error-500">*</span></label>
                <div class="flex items-center">
                    <span class="rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 py-3 text-slate-500 dark:border-slate-700 dark:bg-slate-800">/</span>
                    <input type="text" name="new_url" value="{{ old('new_url', $redirect->new_url) }}" :required="status !== '410'" placeholder="new-page-path" class="w-full rounded-r-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
                <p class="mt-1 text-xs text-slate-500">The path you want to redirect to. Can be absolute (https://...) or relative.</p>
                @error('new_url') <span class="text-sm text-error-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $redirect->is_active) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-brand-500 rounded border-slate-300 focus:ring-brand-500 dark:border-slate-600 dark:bg-slate-700">
                <span class="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300">Active</span>
            </label>
        </div>

        <button type="submit" class="mt-6 inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 transition-all">
            Update Redirect
        </button>
    </div>
</form>
@endsection
