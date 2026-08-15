@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">Media Library</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage and upload your website's media files.</p>
    </div>
    
    <!-- Upload Dropzone Trigger -->
    <div x-data="{ uploadModalOpen: false }">
        <button @click="uploadModalOpen = true" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-2 text-center font-medium text-white hover:bg-brand-600 lg:px-4 xl:px-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Upload Media
        </button>

        <!-- Upload Modal -->
        <div x-show="uploadModalOpen" class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 p-4" style="display: none;">
            <div @click.outside="uploadModalOpen = false" class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white/90">Upload Files</h3>
                    <button @click="uploadModalOpen = false" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    
                    <div class="flex items-center justify-center w-full mb-4">
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-slate-50 dark:hover:bg-bray-800 dark:bg-slate-700 hover:bg-slate-100 dark:border-slate-600 dark:hover:border-slate-500 dark:hover:bg-slate-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-slate-500 dark:text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-slate-500 dark:text-slate-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">SVG, PNG, JPG, WEBP, GIF or Documents (MAX. 10MB)</p>
                            </div>
                            <input id="dropzone-file" type="file" name="file" class="hidden" required accept="image/*,application/pdf,.doc,.docx,.xls,.xlsx" />
                        </label>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="uploadModalOpen = false" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Upload Media</button>
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

@if($errors->any())
<div class="mb-6 flex w-full border-l-6 border-error bg-error-50 px-7 py-4 shadow-md dark:bg-error-500/15 dark:border-error-500 rounded-lg">
    <div class="w-full">
        <h5 class="mb-1 font-bold text-error-600 dark:text-error-500">Error</h5>
        <ul class="list-disc pl-5 text-sm leading-relaxed text-error-700 dark:text-error-400">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<!-- Filters -->
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">
    <form action="{{ route('admin.media.index') }}" method="GET" class="flex flex-1 items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="w-full rounded-lg border border-slate-300 bg-transparent py-2 pl-10 pr-4 text-slate-800 outline-none transition focus:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        
        <select name="type" class="rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-slate-800 outline-none transition focus:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
            <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Images</option>
            <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Documents</option>
        </select>
        
        <button type="submit" class="rounded-lg bg-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-300 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">Filter</button>
        
        @if(request()->has('search') || request()->has('type'))
            <a href="{{ route('admin.media.index') }}" class="text-sm text-brand-600 hover:underline dark:text-brand-500">Clear</a>
        @endif
    </form>
</div>

<!-- Media Grid -->
<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4" x-data="{ editingMedia: null, detailsModalOpen: false }">
    @forelse($media as $item)
        <div class="group relative aspect-square rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow dark:border-slate-800 dark:bg-slate-800">
            @if(Str::startsWith($item->mime_type, 'image/'))
                <img src="{{ $item->getUrl('thumb') ?: $item->getUrl() }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
            @else
                <div class="flex items-center justify-center w-full h-full bg-slate-50 dark:bg-slate-700/50">
                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
            @endif
            
            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-3">
                <p class="text-white text-xs font-medium truncate mb-2" title="{{ $item->name }}">{{ $item->name }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-slate-300 text-[10px] uppercase">{{ number_format($item->size / 1024, 0) }} KB</span>
                    <div class="flex gap-1">
                        <button @click="editingMedia = {{ $item->toJson() }}; detailsModalOpen = true" class="p-1.5 rounded-md bg-white/20 text-white hover:bg-white/40 backdrop-blur" title="Edit Details">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <form action="{{ route('admin.media.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this media?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 rounded-md bg-error-500/80 text-white hover:bg-error-600 backdrop-blur" title="Delete">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400">
            <svg class="mx-auto h-12 w-12 text-slate-300 dark:text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <p>No media found. Upload some files to get started.</p>
        </div>
    @endforelse

    <!-- Details/Edit Modal -->
    <div x-show="detailsModalOpen" class="fixed inset-0 z-999 flex items-center justify-center bg-black/50 p-4" style="display: none;">
        <div @click.outside="detailsModalOpen = false" class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl dark:bg-slate-800">
            <div class="mb-5 flex items-center justify-between border-b pb-4 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white/90">Media Details</h3>
                <button @click="detailsModalOpen = false" class="text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <template x-if="editingMedia">
                <form :action="'{{ url('admin/media') }}/' + editingMedia.id" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Preview -->
                    <div class="flex flex-col items-center justify-center bg-slate-50 dark:bg-slate-700/50 rounded-lg border border-slate-200 dark:border-slate-700 p-2 h-64 overflow-hidden">
                        <template x-if="editingMedia.mime_type.startsWith('image/')">
                            <img :src="editingMedia.original_url" class="max-w-full max-h-full object-contain" />
                        </template>
                        <template x-if="!editingMedia.mime_type.startsWith('image/')">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="text-sm font-medium text-slate-600 dark:text-slate-400" x-text="editingMedia.mime_type"></span>
                            </div>
                        </template>
                    </div>

                    <!-- Meta Data & Form -->
                    <div class="flex flex-col gap-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-800 dark:text-white">File Name</label>
                            <input type="text" name="name" :value="editingMedia.name" required class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-sm text-slate-800 outline-none transition focus:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                        </div>
                        
                        <template x-if="editingMedia.mime_type.startsWith('image/')">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-800 dark:text-white">Alt Text</label>
                                <input type="text" name="custom_properties[alt]" :value="editingMedia.custom_properties?.alt || ''" class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-sm text-slate-800 outline-none transition focus:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" placeholder="Describe the image..." />
                            </div>
                        </template>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-800 dark:text-white">Caption</label>
                            <input type="text" name="custom_properties[caption]" :value="editingMedia.custom_properties?.caption || ''" class="w-full rounded-lg border border-slate-300 bg-transparent px-4 py-2 text-sm text-slate-800 outline-none transition focus:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                        </div>

                        <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-3 text-xs text-slate-500 dark:text-slate-400 space-y-1 mt-auto">
                            <p class="flex justify-between"><strong>Size:</strong> <span x-text="Math.round(editingMedia.size / 1024) + ' KB'"></span></p>
                            <p class="flex justify-between"><strong>Uploaded:</strong> <span x-text="new Date(editingMedia.created_at).toLocaleDateString()"></span></p>
                            <p class="flex justify-between items-center">
                                <strong>URL:</strong> 
                                <span class="truncate w-32 ml-2" x-text="editingMedia.original_url"></span>
                            </p>
                        </div>

                        <div class="flex justify-end gap-3 mt-4">
                            <button type="button" @click="detailsModalOpen = false" class="rounded-lg px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600">Save Changes</button>
                        </div>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>

<div class="mt-6">
    {{ $media->links() }}
</div>
@endsection
