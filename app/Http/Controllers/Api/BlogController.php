<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthenticateToken;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BlogController extends Controller implements HasMiddleware
{
    // 1|v5FqMKyBNQUTXRn4cRVlbFlscmrUA94A0aY8Hgkc58fa977d

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
    public function index(Request $request)
    {
        $query = Blog::query();

        if ($request->has('user'))
        {
            $query->where('user_id', $request->query('user'));
        }

        $blogs = $query->with(['user', 'category', 'posts'])->latest()->paginate(6);

        return BlogResource::collection($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $blog = Blog::create([
            ...$request->validated(),
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
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update([
            ...$request->validated()
        ]);

        return new BlogResource($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response()->noContent();
    }
}
