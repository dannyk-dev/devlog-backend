<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CommentController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        $auth_middleware = new Middleware('auth:sanctum');

        return [
            $auth_middleware->except(['index'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Post $post)
    {
        $comments = $post->comments()->get();

        $comments->load(['user']);
        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $new_post = $post->comments()->create([
            ...$request->validate(['content' => 'required|string|max:255']),
            'user_id' => $request->user()->id
        ]);

        return new CommentResource($new_post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $updated_post = $comment->update([
            ...$request->validate([
                'name' => 'sometimes|string|max:255'
            ])
        ]);

        return new CommentResource($updated_post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->noContent();
    }
}
