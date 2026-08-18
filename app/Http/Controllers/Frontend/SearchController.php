<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Contracts\SearchServiceInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the global search request.
     */
    public function index(Request $request, SearchServiceInterface $searchService)
    {
        $query = $request->input('q', '');
        $type = $request->input('type', null);

        // Validate type filter if provided
        $validTypes = ['page', 'post', 'product', 'service'];
        if ($type && !in_array($type, $validTypes)) {
            $type = null;
        }

        // Perform the search
        $results = $searchService->search($query, $type, 15);

        // Append existing query strings to pagination links
        $results->appends($request->query());

        return view('frontend.search', compact('results', 'query', 'type'));
    }
}
