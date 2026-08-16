<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">General Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Name <span class="text-error-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" required class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                    @error('name') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $service->slug) }}" placeholder="Leave blank to auto-generate" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                    @error('slug') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Short Description</label>
                    <textarea name="short_description" rows="3" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('short_description', $service->short_description) }}</textarea>
                    @error('short_description') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Full Description</label>
                    <textarea name="full_description" id="full_description" rows="8" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('full_description', $service->full_description) }}</textarea>
                    @error('full_description') <span class="text-sm text-error-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">Advanced Content (JSON)</h3>
            <p class="text-sm text-slate-500 mb-4">Enter arrays as valid JSON formats e.g. ["Feature 1", "Feature 2"].</p>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Features</label>
                    <textarea name="features" rows="3" class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('features', is_array($service->features) ? json_encode($service->features) : $service->features) }}</textarea>
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Benefits</label>
                    <textarea name="benefits" rows="3" class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('benefits', is_array($service->benefits) ? json_encode($service->benefits) : $service->benefits) }}</textarea>
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">FAQ</label>
                    <textarea name="faq" rows="4" placeholder='[{"question":"?","answer":"!"}]' class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('faq', is_array($service->faq) ? json_encode($service->faq) : $service->faq) }}</textarea>
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">CTA Configuration</label>
                    <textarea name="cta" rows="3" placeholder='{"title":"Ready?","url":"/contact","text":"Contact Us"}' class="font-mono w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('cta', is_array($service->cta) ? json_encode($service->cta) : $service->cta) }}</textarea>
                </div>
            </div>
        </div>

        <!-- SEO Section -->
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">SEO Metadata</h3>
            @include('admin.partials.seo-form', ['model' => $service])
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">Publishing</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                        <option value="active" {{ old('status', $service->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $service->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
            <h3 class="mb-4 text-lg font-semibold text-slate-800 dark:text-white/90">Media</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Icon (URL or class)</label>
                    <input type="text" name="icon" value="{{ old('icon', $service->icon) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
                
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Featured Image URL</label>
                    <input type="text" name="featured_image" value="{{ old('featured_image', $service->featured_image) }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-4 py-3 text-center font-medium text-white hover:bg-brand-600 transition-all">
            Save Service
        </button>
    </div>
</div>
