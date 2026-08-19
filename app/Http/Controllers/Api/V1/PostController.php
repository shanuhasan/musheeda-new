<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Resources\V1\PostResource;
use App\Traits\ApiResponse;

class PostController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::published()->get();
        return $this->successResponse(PostResource::collection($posts), 'Posts retrieved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            return $this->errorResponse('Post not found.', 404);
        }
        
        return $this->successResponse(new PostResource($post), 'Post retrieved successfully.');
    }
}
