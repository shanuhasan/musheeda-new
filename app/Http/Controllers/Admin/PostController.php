<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author', 'categories', 'tags'])->latest()->paginate(20);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $users = \App\Models\User::all();
        $posts = Post::latest()->get();
        return view('admin.posts.create', compact('categories', 'tags', 'users', 'posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'reading_time_minutes' => 'integer|min:1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
            'featured_image_alt' => 'nullable|string|max:255',
            'seo' => 'nullable|array',
            'author_id' => 'required|exists:users,id',
            'show_toc' => 'boolean',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string|max:255',
            'faqs.*.answer' => 'required_with:faqs|string',
            'related_posts' => 'nullable|array',
            'related_posts.*' => 'exists:posts,id',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['author_id'] = $request->input('author_id', auth()->id());
        $validated['is_featured'] = $request->has('is_featured');
        $validated['show_toc'] = $request->has('show_toc');
        if ($request->has('faqs')) {
            $validated['faqs'] = array_values(array_filter($request->input('faqs'), function($faq) {
                return !empty($faq['question']) && !empty($faq['answer']);
            }));
        }
        
        // Calculate reading time roughly if not provided
        if (empty($validated['reading_time_minutes'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $validated['reading_time_minutes'] = max(1, ceil($wordCount / 200));
        }

        $post = Post::create($validated);

        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }
        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }
        if (isset($validated['related_posts'])) {
            $post->relatedPosts()->sync($validated['related_posts']);
        }

        if ($request->has('seo') && is_array($request->seo)) {
            $post->syncSeo($request->seo);
        }

        if ($request->hasFile('featured_image')) {
            $media = $post->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
            if ($request->filled('featured_image_alt')) {
                $media->setCustomProperty('alt', $request->input('featured_image_alt'));
                $media->save();
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $users = \App\Models\User::all();
        $posts = Post::where('id', '!=', $post->id)->latest()->get();
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'users', 'posts'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $post->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'reading_time_minutes' => 'integer|min:1',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'featured_image' => 'nullable|image|max:2048',
            'featured_image_alt' => 'nullable|string|max:255',
            'seo' => 'nullable|array',
            'author_id' => 'required|exists:users,id',
            'show_toc' => 'boolean',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'required_with:faqs|string|max:255',
            'faqs.*.answer' => 'required_with:faqs|string',
            'related_posts' => 'nullable|array',
            'related_posts.*' => 'exists:posts,id',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['show_toc'] = $request->has('show_toc');
        if ($request->has('faqs')) {
            $validated['faqs'] = array_values(array_filter($request->input('faqs'), function($faq) {
                return !empty($faq['question']) && !empty($faq['answer']);
            }));
        }
        
        // Calculate reading time roughly if not provided
        if (empty($validated['reading_time_minutes'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $validated['reading_time_minutes'] = max(1, ceil($wordCount / 200));
        }

        $post->update($validated);

        if (isset($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        } else {
            $post->categories()->detach();
        }

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        } else {
            $post->tags()->detach();
        }

        if (isset($validated['related_posts'])) {
            $post->relatedPosts()->sync($validated['related_posts']);
        } else {
            $post->relatedPosts()->detach();
        }

        if ($request->has('seo') && is_array($request->seo)) {
            $post->syncSeo($request->seo);
        }

        if ($request->hasFile('featured_image')) {
            $post->clearMediaCollection('featured_image');
            $media = $post->addMediaFromRequest('featured_image')->toMediaCollection('featured_image');
            if ($request->filled('featured_image_alt')) {
                $media->setCustomProperty('alt', $request->input('featured_image_alt'));
                $media->save();
            }
        } elseif ($request->filled('featured_image_alt')) {
            $media = $post->getFirstMedia('featured_image');
            if ($media) {
                $media->setCustomProperty('alt', $request->input('featured_image_alt'));
                $media->save();
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
