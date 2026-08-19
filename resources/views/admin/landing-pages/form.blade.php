@extends('layouts.admin')

@section('title', isset($landingPage) ? 'Edit Landing Page' : 'Create Landing Page')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ isset($landingPage) ? 'Edit Landing Page' : 'Create Landing Page' }}
</h2>
@endsection

@section('content')
<div class="py-12" x-data="landingBuilder(@js(old('blocks', $landingPage->blocks ?? [])))">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if ($errors->any())
            <div class="mb-4 bg-red-50 p-4 rounded-md">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($landingPage) ? route('admin.landing-pages.update', $landingPage) : route('admin.landing-pages.store') }}" method="POST">
            @csrf
            @if(isset($landingPage))
                @method('PUT')
            @endif

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Main Builder Area -->
                <div class="w-full lg:w-2/3 space-y-6">
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Page Information</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('title', $landingPage->title ?? '') }}" required onkeyup="document.getElementById('slug').value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '')">
                            </div>
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700">URL Slug</label>
                                <input type="text" name="slug" id="slug" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('slug', $landingPage->slug ?? '') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Builder Blocks -->
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Page Blocks</h3>
                        </div>

                        <!-- Hidden input to store JSON for submission -->
                        <input type="hidden" name="blocks" x-bind:value="JSON.stringify(blocks)">

                        <div class="space-y-4">
                            <template x-for="(block, index) in blocks" :key="block.id">
                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 relative group">
                                    
                                    <!-- Block Header / Controls -->
                                    <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-200">
                                        <div class="flex items-center space-x-2">
                                            <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded uppercase font-bold" x-text="block.type"></span>
                                        </div>
                                        <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" @click="moveUp(index)" :disabled="index === 0" class="text-gray-500 hover:text-indigo-600 disabled:opacity-30">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                            </button>
                                            <button type="button" @click="moveDown(index)" :disabled="index === blocks.length - 1" class="text-gray-500 hover:text-indigo-600 disabled:opacity-30">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                            <button type="button" @click="removeBlock(index)" class="text-red-500 hover:text-red-700 ml-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Block Content Form -->
                                    <div class="space-y-4">
                                        
                                        <!-- HERO BLOCK -->
                                        <template x-if="block.type === 'hero'">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Heading</label>
                                                    <input type="text" x-model="block.data.heading" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Subheading</label>
                                                    <textarea x-model="block.data.subheading" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Button Text</label>
                                                        <input type="text" x-model="block.data.button_text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Button URL</label>
                                                        <input type="text" x-model="block.data.button_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Image URL</label>
                                                    <div class="flex gap-2">
                                                        <input type="text" x-model="block.data.image_url" placeholder="/images/hero.jpg" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <label class="mt-1 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                                            Upload
                                                            <input type="file" class="hidden" accept="image/*" @change="uploadImage($event, block)">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- TEXT BLOCK -->
                                        <template x-if="block.type === 'text'">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-700">Content (HTML allowed)</label>
                                                <textarea x-model="block.data.content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                            </div>
                                        </template>

                                        <!-- IMAGE_TEXT BLOCK -->
                                        <template x-if="block.type === 'image_text'">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Heading</label>
                                                        <input type="text" x-model="block.data.heading" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Image Position</label>
                                                        <select x-model="block.data.image_position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                            <option value="left">Left</option>
                                                            <option value="right">Right</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Text Content</label>
                                                    <textarea x-model="block.data.text" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Image URL</label>
                                                    <div class="flex gap-2">
                                                        <input type="text" x-model="block.data.image_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <label class="mt-1 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                                                            Upload
                                                            <input type="file" class="hidden" accept="image/*" @change="uploadImage($event, block)">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- CTA BLOCK -->
                                        <template x-if="block.type === 'cta'">
                                            <div class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Heading</label>
                                                    <input type="text" x-model="block.data.heading" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Subtext</label>
                                                    <input type="text" x-model="block.data.text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Button Text</label>
                                                        <input type="text" x-model="block.data.button_text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700">Button URL</label>
                                                        <input type="text" x-model="block.data.button_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- FEATURES BLOCK -->
                                        <template x-if="block.type === 'features'">
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-700">Section Title</label>
                                                    <input type="text" x-model="block.data.title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                </div>
                                                
                                                <div class="mt-4">
                                                    <label class="block text-xs font-bold text-gray-700 mb-2">Features Items</label>
                                                    <div class="space-y-2">
                                                        <template x-for="(item, i) in block.data.items" :key="i">
                                                            <div class="flex gap-2 items-start bg-white p-2 border border-gray-200 rounded">
                                                                <input type="text" x-model="item.title" placeholder="Feature Title" class="block w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                                                                <input type="text" x-model="item.description" placeholder="Description" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                                                                <button type="button" @click="block.data.items.splice(i, 1)" class="text-red-500 hover:text-red-700 p-1">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                                </button>
                                                            </div>
                                                        </template>
                                                        <button type="button" @click="if(!block.data.items) block.data.items = []; block.data.items.push({title: '', description: ''})" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">+ Add Feature</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- HTML BLOCK -->
                                        <template x-if="block.type === 'html'">
                                            <div>
                                                <div class="flex justify-between items-center mb-1">
                                                    <label class="block text-xs font-medium text-gray-700">Raw HTML Code</label>
                                                    @if(!auth()->user()->hasRole('Super Admin'))
                                                        <span class="text-xs text-red-600 font-bold">Only Super Admins can save this block.</span>
                                                    @endif
                                                </div>
                                                <textarea x-model="block.data.content" rows="6" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm font-mono text-xs text-gray-800"></textarea>
                                            </div>
                                        </template>

                                    </div>
                                </div>
                            </template>

                            <div x-show="blocks.length === 0" class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                                No blocks added yet. Click a button below to start building.
                            </div>
                        </div>

                        <!-- Add Block Buttons -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Add Section</h4>
                            <div class="flex flex-wrap gap-2">
                                <button type="button" @click="addBlock('hero')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    + Hero
                                </button>
                                <button type="button" @click="addBlock('text')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    + Text
                                </button>
                                <button type="button" @click="addBlock('image_text')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    + Image + Text
                                </button>
                                <button type="button" @click="addBlock('features')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    + Features
                                </button>
                                <button type="button" @click="addBlock('cta')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                    + Call to Action
                                </button>
                                @if(auth()->user()->hasRole('Super Admin'))
                                <button type="button" @click="addBlock('html')" class="inline-flex items-center px-3 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-red-50 hover:bg-red-100">
                                    + Custom HTML
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Settings -->
                <div class="w-full lg:w-1/3 space-y-6">
                    <div class="bg-white p-6 shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Publishing</h3>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="draft" {{ old('status', $landingPage->status ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $landingPage->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Landing Page
                            </button>
                        </div>
                    </div>

                    <!-- SEO Section (Using the generic component we built earlier) -->
                    @include('admin.partials.seo-form', ['model' => $landingPage ?? null])

                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('landingBuilder', (initialBlocks) => ({
            blocks: initialBlocks || [],
            
            generateId() {
                return 'block_' + Math.random().toString(36).substr(2, 9);
            },
            
            addBlock(type) {
                let defaultData = {};
                switch(type) {
                    case 'hero':
                        defaultData = { heading: '', subheading: '', button_text: '', button_url: '', image_url: '' };
                        break;
                    case 'text':
                        defaultData = { content: '' };
                        break;
                    case 'image_text':
                        defaultData = { heading: '', text: '', image_url: '', image_position: 'left' };
                        break;
                    case 'features':
                        defaultData = { title: '', items: [] };
                        break;
                    case 'cta':
                        defaultData = { heading: '', text: '', button_text: '', button_url: '' };
                        break;
                    case 'html':
                        defaultData = { content: '<!-- Your custom HTML here -->' };
                        break;
                }
                
                this.blocks.push({
                    id: this.generateId(),
                    type: type,
                    data: defaultData
                });
            },
            
            removeBlock(index) {
                if(confirm('Are you sure you want to remove this block?')) {
                    this.blocks.splice(index, 1);
                }
            },
            
            moveUp(index) {
                if(index > 0) {
                    const temp = this.blocks[index];
                    this.blocks[index] = this.blocks[index - 1];
                    this.blocks[index - 1] = temp;
                }
            },
            
            moveBlockDown(index) {
                if (index < this.blocks.length - 1) {
                    const block = this.blocks[index];
                    this.blocks.splice(index, 1);
                    this.blocks.splice(index + 1, 0, block);
                }
            },
            
            async uploadImage(event, block) {
                const file = event.target.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('file', file);
                
                try {
                    // Assuming we have a media upload endpoint, otherwise fallback to basic URL
                    const response = await fetch('{{ route("admin.media.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    if (data.success && data.url) {
                        block.data.image_url = data.url;
                        alert('Image uploaded successfully!');
                    } else {
                        alert('Failed to upload image.');
                    }
                } catch (error) {
                    console.error('Upload Error:', error);
                    alert('An error occurred while uploading.');
                }
            }
        }));
    });
</script>
@endpush
@endsection
