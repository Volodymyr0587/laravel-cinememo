<?php

use App\Livewire\Admin;

//TODO Add admin middleware based on spatie permissions

Route::middleware(['auth'])->group(function () {
     Route::prefix('admin') // Adds '/admin' to the URL of all routes in this group
        ->name('admin.') // Prefixes route names with 'admin.'
        ->group(
            function () {
                Route::get('users', Admin\Users\Index::class)->name('users.index'); // Route name: 'admin.users.index'
            }
        );
});
