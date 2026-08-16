@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">
        Products
    </h2>

    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center gap-2.5 rounded-md bg-brand-500 px-4 py-2 text-center font-medium text-white hover:bg-brand-600 transition-colors">
        <span>
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </span>
        Add Product
    </a>
</div>

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
    <div class="max-w-full overflow-x-auto">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-slate-50 text-left dark:bg-slate-800">
                    <th class="min-w-[220px] px-4 py-4 font-medium text-slate-800 dark:text-white xl:pl-5">Product Name</th>
                    <th class="px-4 py-4 font-medium text-slate-800 dark:text-white">Price</th>
                    <th class="min-w-[150px] px-4 py-4 font-medium text-slate-800 dark:text-white">Status</th>
                    <th class="px-4 py-4 text-right font-medium text-slate-800 dark:text-white xl:pr-5">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="border-b border-slate-200 px-4 py-5 pl-5 dark:border-slate-800">
                        <div class="flex items-center gap-3">
                            <p class="text-slate-800 dark:text-white font-medium">
                                {{ $product->name }}
                            </p>
                        </div>
                    </td>
                    <td class="border-b border-slate-200 px-4 py-5 dark:border-slate-800 text-slate-500">
                        {{ $product->price ? '$' . number_format($product->price, 2) : 'Custom' }}
                    </td>
                    <td class="border-b border-slate-200 px-4 py-5 dark:border-slate-800">
                        @if($product->status == 'active')
                            <span class="inline-flex rounded-full bg-success-50 px-2.5 py-0.5 text-sm font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">Active</span>
                        @elseif($product->status == 'discontinued')
                            <span class="inline-flex rounded-full bg-error-50 px-2.5 py-0.5 text-sm font-medium text-error-700 dark:bg-error-500/10 dark:text-error-400">Discontinued</span>
                        @else
                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-sm font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-400">Inactive</span>
                        @endif
                    </td>
                    <td class="border-b border-slate-200 px-4 py-5 pr-5 text-right dark:border-slate-800">
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-brand-500 hover:text-brand-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-error-500 hover:text-error-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">
                        No products found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="mt-4">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
