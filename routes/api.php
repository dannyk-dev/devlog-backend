<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use App\Http\Middleware\AuthenticateToken;
use App\Http\Resources\StandardResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([AuthenticateToken::class, 'auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return new StandardResource($request->user());
    });
});


Route::apiResource('categories', CategoryController::class)->only(['index', 'show' ]);

Route::apiResource('posts', PostController::class);

Route::apiResource('posts.comments', CommentController::class)->scoped()->except('show');

Route::apiResource('tags', TagController::class)->only(['index', 'show']);
