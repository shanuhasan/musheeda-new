<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Us') }}
        </h2>
    </x-slot>

    <!-- Hero Section -->
    <section class="bg-brand-900 text-white py-20 lg:py-32">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Get in Touch</h1>
            <p class="text-xl text-brand-100 max-w-2xl mx-auto">
                Have a question about our services, need a demo, or want to explore how we can help your business grow? Send us a message and our team will get back to you shortly.
            </p>
        </div>
    </section>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mt-8">
                
                <!-- Left: Info -->
                <div class="space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 text-slate-700">
                            <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Email us at</p>
                                <a href="mailto:{{ setting('contact_email', 'hello@example.com') }}" class="text-brand-600 hover:underline">{{ setting('contact_email', 'hello@example.com') }}</a>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 text-slate-700">
                            <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Call us at</p>
                                <a href="tel:{{ setting('contact_phone') }}" class="text-brand-600 hover:underline">{{ setting('contact_phone', '+1 (555) 123-4567') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Form -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-slate-100 relative">
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-brand-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-blue-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
                    
                    <h3 class="text-2xl font-bold text-slate-900 mb-6 relative">Send an Inquiry</h3>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex gap-3 relative">
                            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('leads.store') }}" method="POST" class="space-y-5 relative">
                        @csrf
                        <input type="hidden" name="source" value="contact">
                        
                        <!-- Honeypot -->
                        <div style="display:none;">
                            <label for="website_url">Leave this field empty</label>
                            <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors bg-slate-50 hover:bg-white focus:bg-white" placeholder="John Doe">
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors bg-slate-50 hover:bg-white focus:bg-white" placeholder="john@example.com">
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors bg-slate-50 hover:bg-white focus:bg-white" placeholder="+1 (555) 000-0000">
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="company" class="block text-sm font-medium text-slate-700 mb-1">Company / Organization</label>
                            <input type="text" name="company" id="company" value="{{ old('company') }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors bg-slate-50 hover:bg-white focus:bg-white" placeholder="Acme Inc.">
                            @error('company') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700 mb-1">Your Message <span class="text-red-500">*</span></label>
                            <textarea name="message" id="message" rows="4" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors bg-slate-50 hover:bg-white focus:bg-white resize-none" placeholder="How can we help you?">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all hover:scale-[1.01]">
                            Send Message
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
