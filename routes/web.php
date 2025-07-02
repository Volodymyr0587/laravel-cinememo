<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\ContentTypes;
use App\Livewire\ContentItems;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Content Types Routes
    Route::get('/content-types', ContentTypes\Index::class)->name('content-types.index');
    Route::get('/content-types/create', ContentTypes\Create::class)->name('content-types.create');
    Route::get('/content-types/{contentType}/edit', ContentTypes\Edit::class)->name('content-types.edit');

    // Content Items Routes
    Route::get('/content-items', ContentItems\Index::class)->name('content-items.index');
    Route::get('/content-items/create', ContentItems\Create::class)->name('content-items.create');
    Route::get('/content-items/{contentItem}/edit', ContentItems\Edit::class)->name('content-items.edit');
});

require __DIR__.'/auth.php';
