@if(setting('google_site_verification'))
    <!-- Google Search Console -->
    <meta name="google-site-verification" content="{{ setting('google_site_verification') }}" />
@endif

@if(setting('google_analytics_id') || setting('google_tag_manager_id'))
    @if(setting('google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics_id') }}"></script>
    @endif
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        
        // Google Consent Mode v2
        @if(setting('cookie_consent_enabled', '1') == '1')
            // Default to denied if consent is enabled
            gtag('consent', 'default', {
                'ad_storage': 'denied',
                'ad_user_data': 'denied',
                'ad_personalization': 'denied',
                'analytics_storage': 'denied'
            });

            // Update to granted if cookie exists
            if (document.cookie.indexOf('cookie_consent=accepted') !== -1) {
                gtag('consent', 'update', {
                    'ad_storage': 'granted',
                    'ad_user_data': 'granted',
                    'ad_personalization': 'granted',
                    'analytics_storage': 'granted'
                });
            }
        @else
            // Default to granted if consent banner is disabled
            gtag('consent', 'default', {
                'ad_storage': 'granted',
                'ad_user_data': 'granted',
                'ad_personalization': 'granted',
                'analytics_storage': 'granted'
            });
        @endif

        @if(session('conversion'))
            // Push Conversion Event
            gtag('event', '{{ session('conversion.event') }}', {!! json_encode(session('conversion.data', [])) !!});
        @endif

        gtag('js', new Date());
        
        @if(setting('google_analytics_id'))
            gtag('config', '{{ setting('google_analytics_id') }}');
        @endif
    </script>
@endif

@if(setting('google_tag_manager_id'))
    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ setting('google_tag_manager_id') }}');
    </script>
@endif

@if(setting('adsense_publisher_id'))
    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ setting('adsense_publisher_id') }}" crossorigin="anonymous"></script>
@endif