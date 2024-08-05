<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Blog;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        $auth_middleware = new Middleware('auth:sanctum');

        return [
            $auth_middleware->except(['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Blog $blog)
    {
        $posts = $blog->posts()
                    ->with(['blog', 'tags'])
                    ->latest()
                    ->paginate(6);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, Blog $blog)
    {
        $posts = $blog->posts()->create([
            ...$request->validated(),
            'blog_id' => $blog->id
        ])->with(['blog', 'tags']);

        return PostResource::collection($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog, Post $post)
    {
        $post->load(['blog', 'tags']);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
