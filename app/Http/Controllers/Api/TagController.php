<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\StandardResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::query()->paginate(6);

        return StandardResource::collection($tags);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $tag->load('posts');

        return new StandardResource($tag);
    }
}
