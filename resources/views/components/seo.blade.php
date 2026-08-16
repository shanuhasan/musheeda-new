@props(['model' => null])

@php
    $seo = new \App\Services\SeoService();
    $seo->setModel($model);
@endphp

<!-- Primary Meta Tags -->
<title>{{ $seo->getTitle() }}</title>
<meta name="description" content="{{ $seo->getDescription() }}">
@if($seo->getKeywords())
<meta name="keywords" content="{{ $seo->getKeywords() }}">
@endif
<meta name="robots" content="{{ $seo->getRobots() }}">
<link rel="canonical" href="{{ $seo->getCanonicalUrl() }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $seo->getSchemaType() === 'Article' ? 'article' : 'website' }}">
<meta property="og:url" content="{{ $seo->getCanonicalUrl() }}">
<meta property="og:title" content="{{ $seo->getOgTitle() }}">
<meta property="og:description" content="{{ $seo->getOgDescription() }}">
@if($seo->getOgImage())
<meta property="og:image" content="{{ $seo->getOgImage() }}">
@endif

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $seo->getCanonicalUrl() }}">
<meta name="twitter:title" content="{{ $seo->getTwitterTitle() }}">
<meta name="twitter:description" content="{{ $seo->getTwitterDescription() }}">
@if($seo->getTwitterImage())
<meta name="twitter:image" content="{{ $seo->getTwitterImage() }}">
@endif

<!-- Structured Data -->
<script type="application/ld+json">
    {!! $seo->generateSchema() !!}
</script>
