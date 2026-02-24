<?php

use Illuminate\Support\Facades\Route;

// Serve static files - these routes bypass session middleware by returning raw response
Route::get('/', function () {
    return response()->file(public_path('index.html'));
})->name('index');

Route::get('/signup.html', function () {
    return response()->file(public_path('signup.html'));
})->name('signup');
