<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route::get('/products',  action: fn() => app(ProductController::class)->index())->name('products');

    // Route::get('/notes/{note}', function ($note) {
    //     return view("notes.{$note}");
    // })->name('notes.show');

    // Route::get('/analytics', fn() => view('analytics'))->name('analytics');
});
