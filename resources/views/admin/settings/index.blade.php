@extends('layouts.admin')

@section('content')
<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-title-md2 font-bold text-slate-800 dark:text-white/90">Website Settings</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage global configuration for header, footer, and basic info.</p>
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

<div x-data="{ activeTab: 'general' }">
    <!-- Tabs -->
    <div class="mb-6 flex flex-wrap gap-2 border-b border-slate-200 pb-4 dark:border-slate-800">
        <button @click="activeTab = 'general'" :class="{'bg-brand-500 text-white': activeTab === 'general', 'bg-white text-slate-700 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700': activeTab !== 'general'}" class="rounded-lg px-4 py-2 font-medium transition-colors">
            General
        </button>
        <button @click="activeTab = 'header'" :class="{'bg-brand-500 text-white': activeTab === 'header', 'bg-white text-slate-700 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700': activeTab !== 'header'}" class="rounded-lg px-4 py-2 font-medium transition-colors">
            Header
        </button>
        <button @click="activeTab = 'footer'" :class="{'bg-brand-500 text-white': activeTab === 'footer', 'bg-white text-slate-700 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700': activeTab !== 'footer'}" class="rounded-lg px-4 py-2 font-medium transition-colors">
            Footer
        </button>
        <button @click="activeTab = 'socials'" :class="{'bg-brand-500 text-white': activeTab === 'socials', 'bg-white text-slate-700 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700': activeTab !== 'socials'}" class="rounded-lg px-4 py-2 font-medium transition-colors">
            Social Links
        </button>
        <button @click="activeTab = 'integrations'" :class="{'bg-brand-500 text-white': activeTab === 'integrations', 'bg-white text-slate-700 hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700': activeTab !== 'integrations'}" class="rounded-lg px-4 py-2 font-medium transition-colors">
            Integrations
        </button>
    </div>

    <!-- Forms -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-white/[0.03]">
        
        <!-- General Tab -->
        <div x-show="activeTab === 'general'" class="p-6">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="group" value="general">
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Site Name</label>
                    <input type="text" name="settings[site_name]" value="{{ $settings['site_name'] ?? 'Musheeda Solutions' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Contact Email</label>
                    <input type="email" name="settings[contact_email]" value="{{ $settings['contact_email'] ?? '' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>

                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Contact Phone</label>
                    <input type="text" name="settings[contact_phone]" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-8 xl:px-10">
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Header Tab -->
        <div x-show="activeTab === 'header'" class="p-6" style="display: none;">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="group" value="header">
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Header Logo Text (or URL to Image)</label>
                    <input type="text" name="settings[header_logo]" value="{{ $settings['header_logo'] ?? 'Musheeda' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">CTA Button Text</label>
                    <input type="text" name="settings[header_cta_text]" value="{{ $settings['header_cta_text'] ?? 'Get a Quote' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">CTA Button URL</label>
                    <input type="text" name="settings[header_cta_url]" value="{{ $settings['header_cta_url'] ?? '/contact' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-8 xl:px-10">
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Footer Tab -->
        <div x-show="activeTab === 'footer'" class="p-6" style="display: none;">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="group" value="footer">
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Footer About Text</label>
                    <textarea name="settings[footer_about]" rows="4" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ $settings['footer_about'] ?? 'Musheeda Solutions provides cutting edge IT services.' }}</textarea>
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Copyright Text</label>
                    <input type="text" name="settings[footer_copyright]" value="{{ $settings['footer_copyright'] ?? '© 2026 Musheeda Solutions. All rights reserved.' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-8 xl:px-10">
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Socials Tab -->
        <div x-show="activeTab === 'socials'" class="p-6" style="display: none;">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="group" value="socials">
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Facebook URL</label>
                    <input type="url" name="settings[social_facebook]" value="{{ $settings['social_facebook'] ?? '' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Twitter URL</label>
                    <input type="url" name="settings[social_twitter]" value="{{ $settings['social_twitter'] ?? '' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">LinkedIn URL</label>
                    <input type="url" name="settings[social_linkedin]" value="{{ $settings['social_linkedin'] ?? '' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>

                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Instagram URL</label>
                    <input type="url" name="settings[social_instagram]" value="{{ $settings['social_instagram'] ?? '' }}" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-8 xl:px-10">
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Integrations Tab -->
        <div x-show="activeTab === 'integrations'" class="p-6" style="display: none;">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="group" value="integrations">
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Google Analytics ID</label>
                    <input type="text" name="settings[google_analytics_id]" value="{{ $settings['google_analytics_id'] ?? '' }}" placeholder="e.g. G-XXXXXXXXXX" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Google Tag Manager ID</label>
                    <input type="text" name="settings[google_tag_manager_id]" value="{{ $settings['google_tag_manager_id'] ?? '' }}" placeholder="e.g. GTM-XXXXXXX" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <div class="mb-5">
                    <label class="mb-3 block text-sm font-medium text-slate-800 dark:text-white">Google AdSense Publisher ID</label>
                    <input type="text" name="settings[adsense_publisher_id]" value="{{ $settings['adsense_publisher_id'] ?? '' }}" placeholder="e.g. ca-pub-XXXXXXXXXXXXXXXX" class="w-full rounded-lg border border-slate-300 bg-transparent px-5 py-3 text-slate-800 outline-none transition focus:border-brand-500 active:border-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white" />
                </div>
                
                <button type="submit" class="inline-flex items-center justify-center gap-2.5 rounded-lg bg-brand-500 px-6 py-3 text-center font-medium text-white hover:bg-brand-600 lg:px-8 xl:px-10">
                    Save Changes
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
