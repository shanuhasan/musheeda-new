<div>
    <!-- Walk as if you are kissing the Earth with your feet. - Thich Nhat Hanh -->
    <div class="bg-brand-50 dark:bg-brand-900/20 rounded-2xl p-8 lg:p-12 border border-brand-100 dark:border-brand-800">
        <div class="max-w-2xl mx-auto text-center">
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">{{ $title }}</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-8">{{ $description }}</p>
            
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="relative max-w-lg mx-auto">
                @csrf
                <input type="hidden" name="source" value="{{ $source }}">
                
                <!-- Honeypot field (hidden from users, but visible to bots) -->
                <div style="display:none;">
                    <label for="website_url">Website URL</label>
                    <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                </div>
    
                <div class="flex flex-col sm:flex-row gap-3">
                    <input 
                        type="email" 
                        name="email" 
                        required
                        placeholder="Enter your email address" 
                        class="flex-1 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:border-brand-500 focus:ring-brand-500 shadow-sm"
                    >
                    <button 
                        type="submit" 
                        class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-base font-bold text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors"
                    >
                        Subscribe
                    </button>
                </div>
                
                @error('email')
                    <p class="mt-2 text-sm text-error-600 dark:text-error-400 text-left">{{ $message }}</p>
                @enderror
            </form>
            
            <p class="mt-4 text-xs text-slate-500 dark:text-slate-500">
                We respect your privacy. You can unsubscribe at any time.
            </p>
        </div>
    </div>
</div>