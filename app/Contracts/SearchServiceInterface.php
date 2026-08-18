<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SearchServiceInterface
{
    /**
     * Search across content types.
     *
     * @param string $query The search query.
     * @param string|null $type The content type to filter by (e.g. 'post', 'page', 'product', 'service').
     * @param int $perPage The number of items per page.
     * @return LengthAwarePaginator
     */
    public function search(string $query, ?string $type = null, int $perPage = 15): LengthAwarePaginator;
}
