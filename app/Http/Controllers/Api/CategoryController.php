<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with(['blogs', 'blogs.user'])->latest()->get();

        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['blogs', 'blogs.user']);

        return new CategoryResource($category);
    }
}
