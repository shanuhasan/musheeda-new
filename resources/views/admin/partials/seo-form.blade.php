@php
    $seo = $model->seoMetadata ?? new \App\Models\SeoMetadata();
@endphp

<div class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-white/[0.03] md:p-6" 
    x-data="{ 
        seoTab: 'general',
        postTitle: document.querySelector('input[name=\'title\']') ? document.querySelector('input[name=\'title\']').value : '',
        postSlug: document.querySelector('input[name=\'slug\']') ? document.querySelector('input[name=\'slug\']').value : '',
        metaTitle: '{{ addslashes(old('seo.meta_title', $seo->meta_title ?? '')) }}',
        metaDesc: '{{ addslashes(old('seo.meta_description', $seo->meta_description ?? '')) }}',
        focusKeyword: '{{ addslashes(old('seo.focus_keyword', $seo->focus_keyword ?? '')) }}',
        
        get displayTitle() {
            return this.metaTitle.trim() !== '' ? this.metaTitle : (this.postTitle.trim() !== '' ? this.postTitle + ' | ' + '{{ config('app.name') }}' : 'Your Page Title');
        },
        get displayDesc() {
            return this.metaDesc.trim() !== '' ? this.metaDesc : 'This is an example of how your meta description will look in search results. Make sure it is compelling and contains your focus keyword.';
        },
        get displayUrl() {
            let base = '{{ url('/') }}';
            let slug = this.postSlug.trim() !== '' ? this.postSlug : (this.postTitle.trim() !== '' ? this.postTitle.toLowerCase().replace(/[^a-z0-9]+/g, '-') : 'page-slug');
            return base + '/' + slug;
        },
        init() {
            let titleInput = document.querySelector('input[name=\'title\']');
            if (titleInput) {
                titleInput.addEventListener('input', (e) => { this.postTitle = e.target.value; });
            }
            let slugInput = document.querySelector('input[name=\'slug\']');
            if (slugInput) {
                slugInput.addEventListener('input', (e) => { this.postSlug = e.target.value; });
            }
        }
    }">
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-slate-200 dark:border-slate-800 pb-4">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white/90">SEO & Social Metadata</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure search engine and social media appearance.</p>
        </div>
        
        <div class="flex space-x-1 rounded-lg bg-slate-100 p-1 dark:bg-slate-800">
            <button type="button" @click="seoTab = 'general'" :class="{ 'bg-white shadow-sm dark:bg-slate-700 dark:text-white': seoTab === 'general', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200': seoTab !== 'general' }" class="rounded-md px-3 py-1.5 text-sm font-medium transition-all">General</button>
            <button type="button" @click="seoTab = 'social'" :class="{ 'bg-white shadow-sm dark:bg-slate-700 dark:text-white': seoTab === 'social', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200': seoTab !== 'social' }" class="rounded-md px-3 py-1.5 text-sm font-medium transition-all">Social</button>
            <button type="button" @click="seoTab = 'advanced'" :class="{ 'bg-white shadow-sm dark:bg-slate-700 dark:text-white': seoTab === 'advanced', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200': seoTab !== 'advanced' }" class="rounded-md px-3 py-1.5 text-sm font-medium transition-all">Advanced</button>
            <button type="button" @click="seoTab = 'analysis'" :class="{ 'bg-white shadow-sm dark:bg-slate-700 dark:text-white': seoTab === 'analysis', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200': seoTab !== 'analysis' }" class="rounded-md px-3 py-1.5 text-sm font-medium transition-all text-brand-600">Analysis</button>
        </div>
    </div>

    <!-- SEO Preview Snippet -->
    <div class="mb-6 rounded-lg bg-slate-50 p-4 border border-slate-100 dark:bg-slate-900/50 dark:border-slate-800">
        <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Search Engine Preview</h4>
        <div class="max-w-[600px] font-sans">
            <div class="text-[14px] text-[#202124] dark:text-slate-300 flex items-center gap-2 mb-1">
                <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden flex items-center justify-center">
                    <span class="text-xs font-bold text-slate-500">{{ substr(config('app.name'), 0, 1) }}</span>
                </div>
                <div>
                    <div class="leading-tight truncate">{{ config('app.name') }}</div>
                    <div class="text-[12px] text-[#4d5156] dark:text-slate-400 truncate" x-text="displayUrl"></div>
                </div>
            </div>
            <a href="#" class="text-[20px] text-[#1a0dab] dark:text-[#8ab4f8] hover:underline cursor-pointer visited:text-[#681da8] dark:visited:text-[#c58af9] leading-tight block mb-1 truncate" x-text="displayTitle"></a>
            <div class="text-[14px] text-[#4d5156] dark:text-slate-400 leading-snug break-words" x-text="displayDesc"></div>
        </div>
    </div>

    <!-- General SEO -->
    <div x-show="seoTab === 'general'" class="space-y-5" style="display: none;">
        <div>
            <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Meta Title</label>
            <input type="text" name="seo[meta_title]" x-model="metaTitle" placeholder="Leave blank to use default title" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
            <div class="mt-1 flex justify-between text-xs">
                <span class="text-slate-500">Optimal length: 50-60 characters</span>
                <span :class="{'text-success-500': metaTitle.length >= 40 && metaTitle.length <= 60, 'text-warning-500': metaTitle.length > 0 && (metaTitle.length < 40 || metaTitle.length > 60), 'text-slate-500': metaTitle.length === 0}" x-text="metaTitle.length + ' / 60'"></span>
            </div>
        </div>
        
        <div>
            <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Meta Description</label>
            <textarea name="seo[meta_description]" x-model="metaDesc" rows="3" placeholder="Leave blank to use default excerpt or description" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all"></textarea>
            <div class="mt-1 flex justify-between text-xs">
                <span class="text-slate-500">Optimal length: 150-160 characters</span>
                <span :class="{'text-success-500': metaDesc.length >= 120 && metaDesc.length <= 160, 'text-warning-500': metaDesc.length > 0 && (metaDesc.length < 120 || metaDesc.length > 160), 'text-slate-500': metaDesc.length === 0}" x-text="metaDesc.length + ' / 160'"></span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Focus Keyword</label>
                <input type="text" name="seo[focus_keyword]" x-model="focusKeyword" placeholder="Main keyword you want to rank for" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
            </div>
            <div>
                <label class="mb-2.5 block text-sm font-medium text-slate-800 dark:text-white/90">Other Meta Keywords</label>
                <input type="text" name="seo[meta_keywords]" value="{{ old('seo.meta_keywords', $seo->meta_keywords) }}" placeholder="keyword1, keyword2, keyword3" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 dark:border-slate-700 dark:bg-slate-900 transition-all">
            </div>
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
    
    <!-- SEO Analysis (Warnings) -->
    <div x-show="seoTab === 'analysis'" class="space-y-4" style="display: none;" x-cloak>
        <h4 class="font-semibold text-slate-800 dark:text-white mb-2">Content Analysis</h4>
        <ul class="space-y-3">
            <!-- Focus Keyword Check -->
            <li class="flex items-start gap-3">
                <template x-if="focusKeyword.length > 0">
                    <svg class="w-5 h-5 text-success-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </template>
                <template x-if="focusKeyword.length === 0">
                    <svg class="w-5 h-5 text-warning-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </template>
                <div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Focus Keyword</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400" x-text="focusKeyword.length > 0 ? 'Focus keyword is set.' : 'Warning: Focus keyword is missing.'"></p>
                </div>
            </li>
            
            <!-- Meta Title Check -->
            <li class="flex items-start gap-3">
                <template x-if="displayTitle.length >= 40 && displayTitle.length <= 60">
                    <svg class="w-5 h-5 text-success-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </template>
                <template x-if="displayTitle.length < 40 || displayTitle.length > 60">
                    <svg class="w-5 h-5 text-warning-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </template>
                <div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">SEO Title Length</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400" x-text="(displayTitle.length < 40 || displayTitle.length > 60) ? 'Warning: SEO title is not optimal length (40-60 chars). Current: ' + displayTitle.length : 'Good: SEO title is optimal length.'"></p>
                </div>
            </li>
            
            <!-- Meta Description Check -->
            <li class="flex items-start gap-3">
                <template x-if="metaDesc.length >= 120 && metaDesc.length <= 160">
                    <svg class="w-5 h-5 text-success-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </template>
                <template x-if="metaDesc.length < 120 || metaDesc.length > 160">
                    <svg class="w-5 h-5 text-warning-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </template>
                <div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Meta Description Length</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400" x-text="(metaDesc.length < 120 || metaDesc.length > 160) ? 'Warning: Meta description is not optimal length (120-160 chars). Current: ' + metaDesc.length : 'Good: Meta description is optimal length.'"></p>
                </div>
            </li>
            
            <li class="flex items-start gap-3">
                <svg class="w-5 h-5 text-brand-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Featured Image Alt Text</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Remember to add descriptive alt text to your featured image before saving to improve accessibility and image SEO.</p>
                </div>
            </li>
        </ul>
        <p class="text-xs text-slate-500 mt-4 italic">Note: These warnings are advisory and will not prevent you from publishing.</p>
    </div>
</div>
