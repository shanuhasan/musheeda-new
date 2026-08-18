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
        $categories = \Illuminate\Support\Facades\Cache::rememberForever('blog.categories', function () {
            return Category::withCount('posts')->orderBy('name')->get();
        });
        $tags = \Illuminate\Support\Facades\Cache::rememberForever('blog.tags', function () {
            return Tag::withCount('posts')->orderBy('name')->get();
        });

        return view('frontend.blog.index', compact('posts', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $post = Post::published()->with(['author', 'categories', 'tags'])->where('slug', $slug)->firstOrFail();
        
        // Sanitize rich content before passing to view to prevent XSS
        $post->sanitized_content = Purifier::clean($post->content);

        // Fetch related posts (first try explicit relation, then fallback to categories)
        $relatedPosts = $post->relatedPosts()->published()->latest('published_at')->take(3)->get();
        if ($relatedPosts->isEmpty()) {
            $categoryIds = $post->categories->pluck('id');
            $relatedPosts = Post::published()
                                ->where('id', '!=', $post->id)
                                ->whereHas('categories', function($q) use ($categoryIds) {
                                    $q->whereIn('categories.id', $categoryIds);
                                })
                                ->latest('published_at')
                                ->take(3)
                                ->get();
        }

        return view('frontend.blog.show', compact('post', 'relatedPosts'))->with('seoModel', $post);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->published()->with(['author', 'categories', 'tags'])->latest('published_at')->paginate(12);
        
        $categories = \Illuminate\Support\Facades\Cache::rememberForever('blog.categories', function () {
            return Category::withCount('posts')->orderBy('name')->get();
        });
        $tags = \Illuminate\Support\Facades\Cache::rememberForever('blog.tags', function () {
            return Tag::withCount('posts')->orderBy('name')->get();
        });

        return view('frontend.blog.index', compact('posts', 'category', 'categories', 'tags'))->with('seoModel', $category);
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->published()->with(['author', 'categories', 'tags'])->latest('published_at')->paginate(12);

        $categories = \Illuminate\Support\Facades\Cache::rememberForever('blog.categories', function () {
            return Category::withCount('posts')->orderBy('name')->get();
        });
        $tags = \Illuminate\Support\Facades\Cache::rememberForever('blog.tags', function () {
            return Tag::withCount('posts')->orderBy('name')->get();
        });

        return view('frontend.blog.index', compact('posts', 'tag', 'categories', 'tags'))->with('seoModel', $tag);
    }
}
