<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PageService
{
    /**
     * Create a new page with SEO metadata and optional featured image.
     */
    public function createPage(array $data, $authorId): Page
    {
        return DB::transaction(function () use ($data, $authorId) {
            $page = Page::create([
                'title' => $data['title'],
                'slug' => $this->generateUniqueSlug($data['slug'] ?? $data['title']),
                'content' => $data['content'],
                'status' => $data['status'],
                'author_id' => $authorId,
                'published_at' => $data['status'] === 'published' ? now() : null,
            ]);

            $this->saveSeoMetadata($page, $data);

            if (isset($data['featured_image'])) {
                $page->addMedia($data['featured_image'])->toMediaCollection('featured_image');
            } elseif (isset($data['featured_image_existing_id'])) {
                $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($data['featured_image_existing_id']);
                if ($media) {
                    $media->copy($page, 'featured_image');
                }
            }

            return $page;
        });
    }

    /**
     * Update an existing page.
     */
    public function updatePage(Page $page, array $data): Page
    {
        return DB::transaction(function () use ($page, $data) {
            $slug = $data['slug'] ?? $data['title'];
            if ($page->slug !== $slug) {
                $slug = $this->generateUniqueSlug($slug, $page->id);
            } else {
                $slug = $page->slug;
            }

            $publishedAt = $page->published_at;
            if ($data['status'] === 'published' && !$publishedAt) {
                $publishedAt = now();
            } elseif ($data['status'] === 'draft') {
                $publishedAt = null;
            }

            $page->update([
                'title' => $data['title'],
                'slug' => $slug,
                'content' => $data['content'],
                'status' => $data['status'],
                'published_at' => $publishedAt,
            ]);

            $this->saveSeoMetadata($page, $data);

            if (isset($data['featured_image'])) {
                $page->clearMediaCollection('featured_image');
                $page->addMedia($data['featured_image'])->toMediaCollection('featured_image');
            } elseif (isset($data['featured_image_existing_id'])) {
                $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::find($data['featured_image_existing_id']);
                if ($media) {
                    $page->clearMediaCollection('featured_image');
                    $media->copy($page, 'featured_image');
                }
            }

            return $page;
        });
    }

    /**
     * Generate a unique slug for the page.
     */
    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Page::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Save SEO metadata for a model.
     */
    protected function saveSeoMetadata($model, array $data): void
    {
        if (isset($data['seo']) && is_array($data['seo'])) {
            $model->syncSeo($data['seo']);
        }
    }
}
