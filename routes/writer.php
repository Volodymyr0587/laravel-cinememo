<?php

use App\Livewire\Articles;

Route::middleware(['auth', 'role:admin|super_admin|writer'])->group(function () {
     Route::prefix('writer') // Adds '/writer' to the URL of all routes in this group
        ->name('writer.') // Prefixes route names with 'writer.'
        ->group(
            function () {
                Route::get('articles', Articles\Index::class)->name('articles.index'); // Route name: 'writer.articles.index'
                Route::get('articles/create', Articles\Create::class)->name('articles.create');
                Route::get('articles/{article}/edit', Articles\Edit::class)->name('articles.edit');
                Route::get('articles/{article}', Articles\Show::class)->name('articles.show');
            }
        );
});
