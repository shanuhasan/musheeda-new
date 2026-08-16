<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->with(['author', 'categories', 'tags'])->latest('published_at');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('posts')->orderBy('name')->get();
        $tags = Tag::withCount('posts')->orderBy('name')->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $post = Post::published()->with(['author', 'categories', 'tags'])->where('slug', $slug)->firstOrFail();
        
        // Sanitize rich content before passing to view to prevent XSS
        $post->sanitized_content = Purifier::clean($post->content);

        // Fetch related posts (same categories, exclude current)
        $categoryIds = $post->categories->pluck('id');
        $relatedPosts = Post::published()
                            ->where('id', '!=', $post->id)
                            ->whereHas('categories', function($q) use ($categoryIds) {
                                $q->whereIn('categories.id', $categoryIds);
                            })
                            ->latest('published_at')
                            ->take(3)
                            ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->published()->with(['author', 'categories', 'tags'])->latest('published_at')->paginate(12);
        
        $categories = Category::withCount('posts')->orderBy('name')->get();
        $tags = Tag::withCount('posts')->orderBy('name')->get();

        return view('frontend.blog.index', compact('posts', 'category', 'categories', 'tags'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->published()->with(['author', 'categories', 'tags'])->latest('published_at')->paginate(12);

        $categories = Category::withCount('posts')->orderBy('name')->get();
        $tags = Tag::withCount('posts')->orderBy('name')->get();

        return view('frontend.blog.index', compact('posts', 'tag', 'categories', 'tags'));
    }
}
