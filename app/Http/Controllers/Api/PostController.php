<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthenticateToken;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        $auth_cookie = new Middleware(AuthenticateToken::class);
        $auth_middleware = new Middleware('auth:sanctum');

        $prevented = ['index', 'show'];

        return [
            $auth_cookie->except($prevented),
            $auth_middleware->except($prevented)
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Post $post)
    {
        $allPosts = Post::with(['user', 'tags'])->latest()->paginate(6);

        return PostResource::collection($allPosts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $post = $request->user()->posts()->create([
            ...$request->validated()
        ]);

        $post->load(['user', 'tags']);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user', 'tags']);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            ...$request->validated()
        ]);

        $post->load(['user', 'tags', ]);
        return new PostResource($post);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
