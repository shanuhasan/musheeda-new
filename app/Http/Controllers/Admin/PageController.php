<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Services\PageService;
use App\Http\Requests\Admin\PageRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PageController extends Controller
{
    use AuthorizesRequests;

    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        $this->authorize('viewAny', Page::class);
        $pages = Page::with('author')->latest()->paginate(15);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $this->authorize('create', Page::class);
        return view('admin.pages.form');
    }

    public function store(PageRequest $request)
    {
        $this->authorize('create', Page::class);
        
        $page = $this->pageService->createPage(
            $request->validated(), 
            auth()->id()
        );

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $this->authorize('update', $page);
        $page->load('seo');
        return view('admin.pages.form', compact('page'));
    }

    public function update(PageRequest $request, Page $page)
    {
        $this->authorize('update', $page);
        
        $this->pageService->updatePage($page, $request->validated());

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
