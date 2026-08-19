<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">General Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Name <span class="text-error-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                    @error('name') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="Leave blank to auto-generate" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                    @error('slug') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Short Description</label>
                    <textarea name="short_description" rows="3" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('short_description', $product->short_description) }}</textarea>
                    @error('short_description') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Full Description</label>
                    <textarea name="description" rows="8" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">Features & Benefits (JSON)</h3>
            <p class="text-sm text-slate-500 mb-4">Enter arrays as valid JSON formats e.g. ["Feature 1", "Feature 2"].</p>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Features</label>
                    <textarea name="features" rows="3" class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('features', is_array($product->features) ? json_encode($product->features) : $product->features) }}</textarea>
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Benefits</label>
                    <textarea name="benefits" rows="3" class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('benefits', is_array($product->benefits) ? json_encode($product->benefits) : $product->benefits) }}</textarea>
                </div>
            </div>
        </div>

        <!-- SEO Section -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">SEO Metadata</h3>
            @include('admin.partials.seo-form', ['model' => $product])
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">Publishing</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                        <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="discontinued" {{ old('status', $product->status) === 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">Pricing & Links</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Price (₹)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Pricing Type</label>
                    <select name="pricing_type" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                        <option value="">Select...</option>
                        <option value="fixed" {{ old('pricing_type', $product->pricing_type) === 'fixed' ? 'selected' : '' }}>Fixed</option>
                        <option value="subscription" {{ old('pricing_type', $product->pricing_type) === 'subscription' ? 'selected' : '' }}>Subscription</option>
                        <option value="custom" {{ old('pricing_type', $product->pricing_type) === 'custom' ? 'selected' : '' }}>Custom Quote</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Demo URL</label>
                    <input type="url" name="demo_url" value="{{ old('demo_url', $product->demo_url) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Documentation URL</label>
                    <input type="url" name="documentation_url" value="{{ old('documentation_url', $product->documentation_url) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">CTA Configuration (JSON)</label>
                    <textarea name="cta" rows="2" placeholder='{"title":"Buy Now","url":"/checkout"}' class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('cta', is_array($product->cta) ? json_encode($product->cta) : $product->cta) }}</textarea>
                </div>
            </div>
        </div>
        
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">Media</h3>
            <div>
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Upload New Image</label>
                <input type="file" name="image_upload" accept="image/*" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                <p class="mt-2 text-sm text-slate-500">Uploading an image here will automatically add it to the Images list.</p>
            </div>
            <div class="mt-4">
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Images (JSON Array of URLs)</label>
                <textarea name="images" rows="2" placeholder='["url1", "url2"]' class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('images', is_array($product->images) ? json_encode($product->images) : $product->images) }}</textarea>
            </div>
            <div class="mt-4">
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">E-Book PDF File (for digital download)</label>
                <input type="file" name="download_file" accept=".pdf,.zip" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                @if($product->download_file_path)
                    <p class="mt-2 text-sm text-slate-500">Current file: {{ $product->download_file_path }}</p>
                @endif
            </div>
        </div>

        <button type="submit" class="w-full inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600 transition-all">
            Save Product
        </button>
    </div>
</div>
