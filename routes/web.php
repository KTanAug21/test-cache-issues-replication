<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('cache', function () {
    return Cache::remember('key', now()->addMinutes(2), function (): array {
        return ['key' => 'value'];
    });
});

Route::get('integrations', function () {
    $user = \App\Models\User::query()->where('email', 'mateus@junges.dev')->first();

    $user->loadMissing('integrations');

    return $user;
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
