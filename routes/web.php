<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Redirect /anasayfa to home
Route::get('/anasayfa', function () {
    return redirect()->route('home');
});

// Dynamic pages
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
