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

Route::get('test', function(){
    $user = \App\Models\User::query()->create([
        'email' => 'kathryn2@laravel.com',
        'password' => bcrypt('password'),
        'name' => 'Kathryn Tan',
    ]);

    \App\Models\Integration::query()->create([
        'owner_type' => 'user',
        'owner_id' => "3",
        'provider' => 'dummy_provider'
    ]);
    dd('ok');
   
});

Route::get('test-get', function(){
    $user = \App\Models\User::query()->where('email', 'kathryn@laravel.com')->first();
 
    $user->loadMissing('integrations');

    return $user;
   
});


Route::get('test-get-loadmissing', function(){
    $user = \App\Models\User::query()->where('email', 'kathryn2@laravel.com')->first();
    $user->loadMissing( 'integrations');

    dd( $user);
});

Route::get('test-get-model', function(){
    $user = \App\Models\User::query()->where('email', 'kathryn2@laravel.com')->first();
    print_r($user);
    
    $inta = \App\Models\Integration::where('owner_id',strval($user->id))->first();

    dd( $inta);
    return $user;
   
});

use Illuminate\Support\Facades\DB;



Route::get('test-query',function(){
    $integrations = DB::select('
        SELECT * FROM "integrations"
        WHERE "owner_id" IN (3) AND "owner_type" = "user"'
    );
    dd( $integrations);
});

Route::get('test-get-allintegrations', function(){
 
    
    $inta = \App\Models\Integration::all();

    dd( $inta);
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
