<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Category front
    Route::get('categories/{category:slug}', CategoryController::class);
    // Post front
    Route::get('posts/{post:slug}', PostController::class);

    // Only for authorized
    Route::prefix('dashboard')->middleware('bearer')->group(function () {
        Route::namespace('App\\Http\\Controllers\\Api\\V1\\Auth')
            ->group(function () {
                // Categories
                Route::get('categories', 'CategoryController@index');
                Route::get('categories/{category}', 'CategoryController@show')
                    ->where('category', '\d+');

                Route::put('categories/{category}', 'CategoryController@update')
                    ->where('category', '\d+');
                Route::post('categories', 'CategoryController@store');
                // Soft cascade delete
                Route::delete('categories/{category}', 'CategoryController@softDelete')
                    ->where('category', '\d+');

                // Posts
                Route::get('posts', 'PostController@index');
                Route::get('posts/{post}', 'PostController@show')
                    ->where('post', '\d+');

                Route::put('posts/{post}', 'PostController@update')
                    ->where('post', '\d+');

                Route::post('posts', 'PostController@store');
                // Soft delete
                Route::delete('posts/{post}', 'PostController@softDelete')
                    ->where('post', '\d+');
            });
    });
});
