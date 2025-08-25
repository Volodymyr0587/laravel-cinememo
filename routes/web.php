<?php

use App\Livewire\Actors;
use App\Livewire\Dashboard;
use App\Livewire\ContentItems;
use App\Livewire\ContentTypes;
use App\Livewire\Settings\Profile;
use App\Exports\ContentItemsExport;
use App\Livewire\Settings\Password;
use Maatwebsite\Excel\Facades\Excel;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use function Spatie\LaravelPdf\Support\pdf;
use App\Livewire\ContentItems\PublicContentItems;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth'])->group(function () {
     // Content Types Routes
    Route::get('/content-types', ContentTypes\Index::class)->name('content-types.index');
    Route::get('/content-types/create', ContentTypes\Create::class)->name('content-types.create');
    Route::get('/content-types/{contentType}/edit', ContentTypes\Edit::class)->name('content-types.edit');

    // Export Content Items to XLSX
    Route::get('/content-items/export', function () {
        $fileName = 'content-items-' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new ContentItemsExport, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    })->name('content-items.export');

    // Content Items Routes
    Route::get('/content-items/trash', ContentItems\Trash::class)->name('content-items.trash');
    Route::get('/content-items', ContentItems\Index::class)->name('content-items.index');
    Route::get('/content-items/create', ContentItems\Create::class)->name('content-items.create');
    Route::get('/content-items/{contentItem}/edit', ContentItems\Edit::class)->name('content-items.edit');
    Route::get('/content-items/{contentItem}', ContentItems\Show::class)->name('content-items.show');

    // Public Items Routes
    Route::get('/public-content', PublicContentItems::class)
        ->name('public-content.index');

    // Export Content Items to PDF
    Route::get('/export-pdf', function () {
        $contentItems = auth()->user()->contentItems()->with('contentType')->get();
        $fileName = 'content-items-' . now()->format('Y-m-d_H-i-s') . '.pdf';
        return pdf()->view('pdf.content-items', ['contentItems' => $contentItems])
        ->format('A4')
        ->name($fileName);
    })->name('content-items.export-pdf');

    // Actors Routes
    Route::get('/actors', Actors\Index::class)->name('actors.index');
    Route::get('/actors/create', Actors\Create::class)->name('actors.create');
    Route::get('/actors/{actor}/edit', Actors\Edit::class)->name('actors.edit');
    Route::get('/actors/{actor}', Actors\Show::class)->name('actors.show');
});

Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'uk'])) {
        session(['locale' => $lang]);
    }
    return redirect()->back();
})->name('locale.switch');

require __DIR__.'/auth.php';
