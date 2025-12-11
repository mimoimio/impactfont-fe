<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\PostController; // Import the controller
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');

// Public route to view all posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Authenticated routes for posts
    Route::get('/new', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/preview', [PostController::class, 'preview'])->name('posts.preview');
    Route::post('/posts/confirm', [PostController::class, 'confirm'])->name('posts.confirm');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
