@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">Build Menu: {{ $menu->name }}</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage items for the {{ $menu->location }} location.</p>
    </div>
    
    <div class="flex gap-3">
        <a href="{{ route('admin.menus.index') }}" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-slate-200 px-4 py-2 text-center font-medium text-slate-700 hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
            Back to Menus
        </a>
        
        <div x-data="{ open: false }">
            <button @click="open = true" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-2 text-center font-medium text-white hover:bg-brand-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Item
            </button>

            <!-- Add Item Modal -->
            <div x-show="open" class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 p-4" style="display: none;">
                <div @click.outside="open = false" class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
                    <div class="mb-5 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white/90">Add Menu Item</h3>
                        <button @click="open = false" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    
                    <form action="{{ route('admin.menu-items.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="navigation_menu_id" value="{{ $menu->id }}">
                        
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">Title</label>
                            <input type="text" name="title" required class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="e.g. About Us" />
                        </div>
                        
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">URL</label>
                            <input type="text" name="url" class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="e.g. /about-us or https://example.com" />
                            <p class="mt-1 text-xs text-slate-500">Leave blank if this is just a parent dropdown trigger.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">Parent Item (for dropdowns)</label>
                            <select name="parent_id" class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                <option value="">None (Top Level)</option>
                                @foreach($menu->items as $parentItem)
                                    @if(is_null($parentItem->parent_id))
                                        <option value="{{ $parentItem->id }}">{{ $parentItem->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 flex gap-4">
                            <div class="flex-1">
                                <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">Target</label>
                                <select name="target" class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                    <option value="_self">Same Window</option>
                                    <option value="_blank">New Tab</option>
                                </select>
                            </div>
                            <div class="w-24">
                                <label class="mb-2 block text-sm font-medium text-slate-800 dark:text-white">Order</label>
                                <input type="number" name="order" value="0" class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                            </div>
                        </div>
                        
                        <div class="mb-5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500 dark:border-slate-600 dark:bg-slate-700 dark:ring-offset-slate-800">
                                <span class="text-sm font-medium text-slate-800 dark:text-white">Item is Active</span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" @click="open = false" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Save Item</button>
                        </div>
                    </form>
                </div>
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

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
    <div class="p-6">
        @if($menu->items->count() > 0)
            <div class="flex flex-col gap-4">
                @foreach($menu->items as $item)
                    @if(is_null($item->parent_id))
                        <div class="rounded-xl border border-slate-200 p-4 dark:border-slate-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="font-semibold text-slate-800 dark:text-white">{{ $item->title }}</span>
                                    @if($item->url)
                                        <span class="text-xs text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">{{ $item->url }}</span>
                                    @endif
                                    @if(!$item->is_active)
                                        <span class="text-xs text-warning-600 bg-warning-50 px-2 py-1 rounded dark:bg-warning-500/15 dark:text-warning-500">Disabled</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-slate-500">Order: {{ $item->order }}</span>
                                    
                                    <form action="{{ route('admin.menu-items.toggle', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 ml-2" title="Toggle Status">
                                            @if($item->is_active)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                            @endif
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this menu item?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-error-600 hover:text-error-900 dark:text-error-500 dark:hover:text-error-400" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if($item->children->count() > 0)
                                <div class="mt-4 flex flex-col gap-2 pl-8 border-l-2 border-slate-100 dark:border-slate-700">
                                    @foreach($item->children as $child)
                                        <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3 dark:bg-slate-800/50">
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm font-medium text-slate-800 dark:text-white">{{ $child->title }}</span>
                                                <span class="text-xs text-slate-500 dark:text-slate-400">{{ $child->url }}</span>
                                                @if(!$child->is_active)
                                                    <span class="text-[10px] text-warning-600 bg-warning-50 px-1.5 py-0.5 rounded dark:bg-warning-500/15 dark:text-warning-500">Disabled</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs text-slate-500">Order: {{ $child->order }}</span>
                                                
                                                <form action="{{ route('admin.menu-items.toggle', $child) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 ml-2" title="Toggle Status">
                                                        @if($child->is_active)
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                        @else
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path></svg>
                                                        @endif
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.menu-items.destroy', $child) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-error-600 hover:text-error-900 dark:text-error-500 dark:hover:text-error-400" title="Delete">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="py-8 text-center text-slate-500 dark:text-slate-400">
                <p>No items in this menu yet. Click "Add Item" to get started.</p>
            </div>
        @endif
    </div>
</div>
@endsection
