<?php

namespace App\Services\Search;

use App\Contracts\SearchServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator as BaseLengthAwarePaginator;
use Illuminate\Support\Collection;

class DatabaseSearchService implements SearchServiceInterface
{
    /**
     * Search across content types.
     *
     * @param string $query The search query.
     * @param string|null $type The content type to filter by (e.g. 'post', 'page', 'product', 'service').
     * @param int $perPage The number of items per page.
     * @return LengthAwarePaginator
     */
    public function search(string $query, ?string $type = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = mb_strtolower(trim($query));
        
        if (empty($query)) {
            return new BaseLengthAwarePaginator([], 0, $perPage, 1, ['path' => Paginator::resolveCurrentPath()]);
        }

        $queries = [];

        // 1. Pages
        if ($type === null || $type === 'page') {
            $queries[] = DB::table('pages')
                ->select([
                    'id',
                    DB::raw("'page' as type"),
                    'title',
                    'slug',
                    DB::raw("'' as excerpt"),
                    'published_at as date'
                ])
                ->where('status', 'published')
                ->where(function($q) use ($query) {
                    $q->where(DB::raw('LOWER(title)'), 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw('LOWER(content)'), 'LIKE', "%{$query}%");
                });
        }

        // 2. Posts
        if ($type === null || $type === 'post') {
            $queries[] = DB::table('posts')
                ->select([
                    'id',
                    DB::raw("'post' as type"),
                    'title',
                    'slug',
                    'excerpt',
                    'published_at as date'
                ])
                ->where('status', 'published')
                ->where(function($q) use ($query) {
                    $q->where(DB::raw('LOWER(title)'), 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw('LOWER(excerpt)'), 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw('LOWER(content)'), 'LIKE', "%{$query}%");
                });
        }

        // 3. Products
        if ($type === null || $type === 'product') {
            $queries[] = DB::table('products')
                ->select([
                    'id',
                    DB::raw("'product' as type"),
                    'name as title',
                    'slug',
                    'short_description as excerpt',
                    'created_at as date'
                ])
                ->where('status', 'published')
                ->where(function($q) use ($query) {
                    $q->where(DB::raw('LOWER(name)'), 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw('LOWER(short_description)'), 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw('LOWER(description)'), 'LIKE', "%{$query}%");
                });
        }

        // 4. Services
        if ($type === null || $type === 'service') {
            $queries[] = DB::table('services')
                ->select([
                    'id',
                    DB::raw("'service' as type"),
                    'name as title',
                    'slug',
                    'short_description as excerpt',
                    'created_at as date'
                ])
                ->where('status', 'published')
                ->where(function($q) use ($query) {
                    $q->where(DB::raw('LOWER(name)'), 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw('LOWER(short_description)'), 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw('LOWER(full_description)'), 'LIKE', "%{$query}%");
                });
        }

        if (empty($queries)) {
            return new BaseLengthAwarePaginator([], 0, $perPage, 1, ['path' => Paginator::resolveCurrentPath()]);
        }

        // Combine all queries using UNION ALL
        $unionQuery = array_shift($queries);
        foreach ($queries as $q) {
            $unionQuery->unionAll($q);
        }

        // We wrap the union query in a subquery to sort and paginate it
        $finalQuery = DB::table(DB::raw("({$unionQuery->toSql()}) as search_results"))
                        ->mergeBindings($unionQuery)
                        ->orderBy('date', 'desc');

        // Note: we can't easily use the built-in paginate() on complex raw subqueries reliably in all DBs without providing the count manually or letting Laravel count.
        // Laravel's paginate() usually works on subqueries, but to be completely safe:
        $paginator = $finalQuery->paginate($perPage);

        // Map results to resolve URLs dynamically, add a generic getUrl() helper property.
        $paginator->getCollection()->transform(function ($item) {
            $item->url = $this->resolveUrl($item->type, $item->slug);
            return $item;
        });

        return $paginator;
    }

    /**
     * Resolve the frontend URL based on the content type and slug.
     */
    protected function resolveUrl(string $type, string $slug): string
    {
        return match($type) {
            'post' => url("/blog/{$slug}"),
            'page' => url("/{$slug}"),
            'product' => url("/products/{$slug}"),
            'service' => url("/services/{$slug}"),
            default => url('/'),
        };
    }
}
