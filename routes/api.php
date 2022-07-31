<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Category front
    Route::get('categories/{category:slug}', CategoryController::class);
    // Post front
    Route::get('posts/{post:slug}', PostController::class);
});
