<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class SeoService
{
    protected ?Model $model = null;
    protected array $settings = [];

    public function __construct()
    {
        // Cache SEO settings to avoid multiple queries
        $this->settings = Cache::remember('seo_settings', 86400, function () {
            return Setting::where('group', 'seo')->pluck('value', 'key')->toArray();
        });
    }

    public function setModel(?Model $model)
    {
        $this->model = $model;
        return $this;
    }

    public function getSetting(string $key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    public function getTitle(): string
    {
        $title = null;
        if ($this->model && $this->model->seoMetadata?->meta_title) {
            $title = $this->model->seoMetadata->meta_title;
        } elseif ($this->model) {
            $title = $this->model->title ?? $this->model->name ?? null;
        }

        $suffix = $this->getSetting('site_name', config('app.name'));

        if ($title) {
            return $title . ' - ' . $suffix;
        }

        return $this->getSetting('default_meta_title', $suffix);
    }

    public function getDescription(): string
    {
        if ($this->model && $this->model->seoMetadata?->meta_description) {
            return $this->model->seoMetadata->meta_description;
        } elseif ($this->model && isset($this->model->excerpt)) {
            return $this->model->excerpt;
        }

        return $this->getSetting('default_meta_description', '');
    }

    public function getKeywords(): string
    {
        if ($this->model && $this->model->seoMetadata?->meta_keywords) {
            return $this->model->seoMetadata->meta_keywords;
        }
        return $this->getSetting('default_meta_keywords', '');
    }

    public function getCanonicalUrl(): string
    {
        if ($this->model && $this->model->seoMetadata?->canonical_url) {
            return $this->model->seoMetadata->canonical_url;
        }
        return Request::url();
    }

    public function getRobots(): string
    {
        if ($this->model && $this->model->seoMetadata?->robots) {
            return $this->model->seoMetadata->robots;
        }
        return 'index, follow';
    }

    public function getOgTitle(): string
    {
        if ($this->model && $this->model->seoMetadata?->og_title) {
            return $this->model->seoMetadata->og_title;
        }
        return $this->getTitle();
    }

    public function getOgDescription(): string
    {
        if ($this->model && $this->model->seoMetadata?->og_description) {
            return $this->model->seoMetadata->og_description;
        }
        return $this->getDescription();
    }

    public function getOgImage(): string
    {
        if ($this->model && $this->model->seoMetadata?->og_image) {
            return asset('storage/' . $this->model->seoMetadata->og_image);
        }

        // Check if model has media
        if ($this->model && method_exists($this->model, 'hasMedia') && $this->model->hasMedia('featured_image')) {
            return $this->model->getFirstMediaUrl('featured_image', 'featured') ?: $this->model->getFirstMediaUrl('featured_image');
        }

        return $this->getSetting('default_og_image') ? asset('storage/' . $this->getSetting('default_og_image')) : '';
    }

    public function getTwitterTitle(): string
    {
        if ($this->model && $this->model->seoMetadata?->twitter_title) {
            return $this->model->seoMetadata->twitter_title;
        }
        return $this->getOgTitle();
    }

    public function getTwitterDescription(): string
    {
        if ($this->model && $this->model->seoMetadata?->twitter_description) {
            return $this->model->seoMetadata->twitter_description;
        }
        return $this->getOgDescription();
    }

    public function getTwitterImage(): string
    {
        if ($this->model && $this->model->seoMetadata?->twitter_image) {
            return asset('storage/' . $this->model->seoMetadata->twitter_image);
        }
        return $this->getOgImage();
    }

    public function getSchemaType(): string
    {
        if ($this->model && $this->model->seoMetadata?->schema_type) {
            return $this->model->seoMetadata->schema_type;
        }

        if ($this->model) {
            $class = class_basename($this->model);
            if ($class === 'Post') return 'Article';
            if ($class === 'Product') return 'Product';
        }

        return 'WebSite';
    }

    public function generateSchema(): ?string
    {
        if ($this->model && $this->model->seoMetadata?->custom_schema) {
            return json_encode($this->model->seoMetadata->custom_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        $type = $this->getSchemaType();
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $type,
        ];

        // WebSite Schema
        if ($type === 'WebSite') {
            $schema['name'] = $this->getSetting('site_name', config('app.name'));
            $schema['url'] = url('/');
            $schema['potentialAction'] = [
                '@type' => 'SearchAction',
                'target' => url('/search?q={search_term_string}'),
                'query-input' => 'required name=search_term_string'
            ];
        }

        // Article Schema
        if ($type === 'Article' && $this->model) {
            $schema['headline'] = $this->getTitle();
            $schema['image'] = [$this->getOgImage()];
            
            if (isset($this->model->published_at)) {
                $schema['datePublished'] = $this->model->published_at->toIso8601String();
            }
            if (isset($this->model->updated_at)) {
                $schema['dateModified'] = $this->model->updated_at->toIso8601String();
            }
            if (isset($this->model->author)) {
                $schema['author'] = [
                    '@type' => 'Person',
                    'name' => $this->model->author->name ?? 'Author',
                ];
            }
        }

        // Organization Schema (always add this graph)
        $orgSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $this->getSetting('org_name', config('app.name')),
            'url' => url('/'),
            'logo' => $this->getSetting('org_logo') ? asset('storage/' . $this->getSetting('org_logo')) : '',
        ];

        return json_encode([$schema, $orgSchema], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
