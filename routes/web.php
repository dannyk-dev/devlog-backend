<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/swagger-docs', function () {
    $path = storage_path('public/swagger.json'); // Adjust the path if needed
    if (!file_exists($path)) {
        abort(404);
    }

    return Response::file($path, [
        'Content-Type' => 'application/json',
        'Content-Disposition' => 'inline; filename="swagger.json"'
    ]);
});
