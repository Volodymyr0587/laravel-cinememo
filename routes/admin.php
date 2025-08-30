<?php

use App\Livewire\Admin;

Route::middleware(['auth', 'role:admin'])->group(function () {
     Route::prefix('admin') // Adds '/admin' to the URL of all routes in this group
        ->name('admin.') // Prefixes route names with 'admin.'
        ->group(
            function () {
                Route::get('users', Admin\Users\Index::class)->name('users.index'); // Route name: 'admin.users.index'
                Route::get('users/{user}/edit', Admin\Users\Edit::class)->name('users.edit');
                Route::get('users/{user}', Admin\Users\Show::class)->name('users.show');
            }
        );
});
