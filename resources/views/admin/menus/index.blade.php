@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">Navigation Menus</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage header, footer, and custom navigation menus.</p>
    </div>
    
    <!-- Add Menu Modal Trigger -->
    <div x-data="{ open: false }">
        <button @click="open = true" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-2 text-center font-medium text-white hover:bg-brand-600 lg:px-4 xl:px-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Create Menu
        </button>

        <!-- Modal -->
        <div x-show="open" class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 p-4" style="display: none;">
            <div @click.outside="open = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white/90">Create Menu</h3>
                    <button @click="open = false" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.menus.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">Menu Name</label>
                        <input type="text" name="name" required class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="e.g. Header Menu" />
                    </div>
                    
                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">Slug</label>
                        <input type="text" name="slug" required class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="e.g. header-menu" />
                    </div>
                    
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">Location</label>
                        <select name="location" required class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="header">Header</option>
                            <option value="footer_1">Footer Section 1</option>
                            <option value="footer_2">Footer Section 2</option>
                            <option value="custom">Custom Location</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="open = false" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Save Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="mb-6 flex w-full border-l-6 border-success bg-success-50 px-7 py-4 shadow-md dark:bg-success-500/15 dark:border-success-500 rounded-lg">
    <div class="mr-5 flex h-9 w-full max-w-[36px] items-center justify-center rounded-lg bg-success">
        <svg class="fill-white" width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.2984 0.826822L15.2868 0.811827L15.2741 0.797751C14.9173 0.401867 14.3238 0.400754 13.9657 0.794406L5.91888 9.45376L2.05667 5.2868C1.69856 4.89287 1.10487 4.89389 0.747996 5.28987C0.417335 5.65675 0.417335 6.22337 0.747996 6.59026L0.747959 6.59029L0.752701 6.59541L4.86742 11.0348C5.14445 11.3405 5.52858 11.5 5.89581 11.5C6.29242 11.5 6.65178 11.3355 6.92401 11.035L15.2162 2.11161C15.5833 1.74452 15.576 1.18615 15.2984 0.826822Z" stroke="white" stroke-width="0.2"></path>
        </svg>
    </div>
    <div class="w-full">
        <h5 class="mb-1 font-bold text-success-600 dark:text-success-500">Success!</h5>
        <p class="text-sm leading-relaxed text-success-700 dark:text-success-400">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
            <thead class="bg-slate-50 dark:bg-slate-800/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Name / Slug</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Location</th>
                    <th scope="col" class="relative px-6 py-4">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($menus as $menu)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-slate-900 dark:text-white/90">{{ $menu->name }}</div>
                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ $menu->slug }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-50 text-brand-600 dark:bg-brand-500/15 dark:text-brand-500">
                            {{ ucfirst($menu->location) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="text-brand-600 hover:text-brand-900 dark:text-brand-500 dark:hover:text-brand-400" title="Manage Items">
                                Build Menu
                            </a>
                            
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this menu?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-error-600 hover:text-error-900 dark:text-error-500 dark:hover:text-error-400" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                        <p class="text-sm">No menus found. Get started by creating a new menu.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
