@php
    $seo = $model->seoMetadata ?? new \App\Models\SeoMetadata();
@endphp

<div class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6" x-data="{ seoTab: 'general' }">
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white/90">SEO & Social Metadata</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure search engine and social media appearance.</p>
        </div>
        
        <div class="flex space-x-1 rounded-lg bg-slate-100 p-1 dark:bg-slate-800">
            <button type="button" @click="seoTab = 'general'" :class="{ 'bg-white shadow-sm dark:bg-slate-700 dark:text-white': seoTab === 'general', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200': seoTab !== 'general' }" class="rounded-md px-3 py-1.5 text-sm font-medium transition-all">General</button>
            <button type="button" @click="seoTab = 'social'" :class="{ 'bg-white shadow-sm dark:bg-slate-700 dark:text-white': seoTab === 'social', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200': seoTab !== 'social' }" class="rounded-md px-3 py-1.5 text-sm font-medium transition-all">Social</button>
            <button type="button" @click="seoTab = 'advanced'" :class="{ 'bg-white shadow-sm dark:bg-slate-700 dark:text-white': seoTab === 'advanced', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200': seoTab !== 'advanced' }" class="rounded-md px-3 py-1.5 text-sm font-medium transition-all">Advanced</button>
        </div>
    </div>

    <!-- General SEO -->
    <div x-show="seoTab === 'general'" class="space-y-5" style="display: none;">
        <div>
            <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Meta Title</label>
            <input type="text" name="seo[meta_title]" value="{{ old('seo.meta_title', $seo->meta_title) }}" placeholder="Leave blank to use default title" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
        </div>
        
        <div>
            <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Meta Description</label>
            <textarea name="seo[meta_description]" rows="3" placeholder="Leave blank to use default excerpt or description" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('seo.meta_description', $seo->meta_description) }}</textarea>
        </div>

        <div>
            <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Meta Keywords</label>
            <input type="text" name="seo[meta_keywords]" value="{{ old('seo.meta_keywords', $seo->meta_keywords) }}" placeholder="keyword1, keyword2, keyword3" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
        </div>
    </div>

    <!-- Social (OG & Twitter) -->
    <div x-show="seoTab === 'social'" class="space-y-6" style="display: none;" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-5">
                <h4 class="font-semibold text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Facebook / Open Graph</h4>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">OG Title</label>
                    <input type="text" name="seo[og_title]" value="{{ old('seo.og_title', $seo->og_title) }}" placeholder="Defaults to Meta Title" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">OG Description</label>
                    <textarea name="seo[og_description]" rows="3" placeholder="Defaults to Meta Description" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('seo.og_description', $seo->og_description) }}</textarea>
                </div>
            </div>

            <div class="space-y-5">
                <h4 class="font-semibold text-slate-800 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2">Twitter / X</h4>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Twitter Title</label>
                    <input type="text" name="seo[twitter_title]" value="{{ old('seo.twitter_title', $seo->twitter_title) }}" placeholder="Defaults to OG Title" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                </div>
                <div>
                    <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Twitter Description</label>
                    <textarea name="seo[twitter_description]" rows="3" placeholder="Defaults to OG Description" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('seo.twitter_description', $seo->twitter_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced SEO -->
    <div x-show="seoTab === 'advanced'" class="space-y-5" style="display: none;" x-cloak>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Canonical URL</label>
                <input type="url" name="seo[canonical_url]" value="{{ old('seo.canonical_url', $seo->canonical_url) }}" placeholder="Leave blank to use current URL" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
            </div>
            
            <div>
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Robots Meta Tag</label>
                <select name="seo[robots]" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                    <option value="index, follow" {{ old('seo.robots', $seo->robots) === 'index, follow' ? 'selected' : '' }}>Index, Follow (Default)</option>
                    <option value="noindex, follow" {{ old('seo.robots', $seo->robots) === 'noindex, follow' ? 'selected' : '' }}>No Index, Follow</option>
                    <option value="index, nofollow" {{ old('seo.robots', $seo->robots) === 'index, nofollow' ? 'selected' : '' }}>Index, No Follow</option>
                    <option value="noindex, nofollow" {{ old('seo.robots', $seo->robots) === 'noindex, nofollow' ? 'selected' : '' }}>No Index, No Follow</option>
                </select>
            </div>

            <div>
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Schema Type</label>
                <select name="seo[schema_type]" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
                    <option value="">Auto-detect based on model type</option>
                    <option value="WebSite" {{ old('seo.schema_type', $seo->schema_type) === 'WebSite' ? 'selected' : '' }}>WebSite</option>
                    <option value="Article" {{ old('seo.schema_type', $seo->schema_type) === 'Article' ? 'selected' : '' }}>Article</option>
                    <option value="Product" {{ old('seo.schema_type', $seo->schema_type) === 'Product' ? 'selected' : '' }}>Product</option>
                    <option value="LocalBusiness" {{ old('seo.schema_type', $seo->schema_type) === 'LocalBusiness' ? 'selected' : '' }}>LocalBusiness</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Custom Schema (JSON-LD)</label>
                <textarea name="seo[custom_schema]" rows="4" placeholder="{&quot;@@context&quot;: &quot;https://schema.org&quot;, &quot;@@type&quot;: &quot;Event&quot;,...}" class="font-mono text-sm w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">{{ old('seo.custom_schema', is_array($seo->custom_schema) ? json_encode($seo->custom_schema, JSON_PRETTY_PRINT) : $seo->custom_schema) }}</textarea>
                <p class="mt-1 text-xs text-slate-500">Must be valid JSON. Overrides auto-generated schema if provided.</p>
            </div>
        </div>
    </div>
</div>
