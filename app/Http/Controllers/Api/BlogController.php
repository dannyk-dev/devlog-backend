<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class BlogController extends Controller implements HasMiddleware
{

    use AuthorizesRequests, Authorizable;

    // 1|v5FqMKyBNQUTXRn4cRVlbFlscmrUA94A0aY8Hgkc58fa977d

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
    public function index()
    {
        $blogs = Blog::with(['user', 'category', 'posts'])->latest()->paginate(6);

        return BlogResource::collection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $blog = Blog::create([
            ...$request->validate([
                'title' => ['required', 'max:255'],
                'description' => 'nullable',
                'category_id' => 'uuid|required|exists:categories,id'
            ]),
            'user_id' => $request->user()->id,
        ]);

        $blog->load(['user', 'category']);

        return new BlogResource($blog);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $blog->load(['user', 'category']);

        return new BlogResource($blog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
