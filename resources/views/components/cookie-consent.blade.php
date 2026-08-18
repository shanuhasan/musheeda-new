@if(setting('cookie_consent_enabled', '1') == '1')
    <div 
        x-data="{ show: false }" 
        x-init="
            if (document.cookie.indexOf('cookie_consent=accepted') === -1) {
                setTimeout(() => show = true, 1000);
            }
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-10"
        class="fixed bottom-0 left-0 z-[9999] w-full border-t border-slate-200 bg-white p-4 shadow-xl dark:border-slate-800 dark:bg-slate-900 md:bottom-4 md:left-4 md:w-[400px] md:rounded-xl md:border"
        style="display: none;"
    >
        <div class="flex flex-col gap-4">
            <div>
                <h4 class="text-base font-semibold text-slate-800 dark:text-white">We Value Your Privacy</h4>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    We use cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking "Accept", you consent to our use of cookies.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <button 
                    @click="
                        document.cookie = 'cookie_consent=accepted; path=/; max-age=31536000';
                        if (typeof gtag === 'function') {
                            gtag('consent', 'update', {
                                'ad_storage': 'granted',
                                'ad_user_data': 'granted',
                                'ad_personalization': 'granted',
                                'analytics_storage': 'granted'
                            });
                        }
                        show = false;
                    "
                    class="flex-1 rounded-lg bg-brand-500 px-4 py-2 text-center text-sm font-medium text-white transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                >
                    Accept
                </button>
                <button 
                    @click="
                        document.cookie = 'cookie_consent=declined; path=/; max-age=31536000';
                        show = false;
                    "
                    class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-center text-sm font-medium text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700 dark:focus:ring-offset-slate-900"
                >
                    Decline
                </button>
            </div>
        </div>
    </div>
@endif