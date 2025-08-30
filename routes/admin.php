<?php

use App\Livewire\Admin;

Route::middleware(['auth', 'role:admin'])->group(function () {
     Route::prefix('admin') // Adds '/admin' to the URL of all routes in this group
        ->name('admin.') // Prefixes route names with 'admin.'
        ->group(
            function () {
                Route::get('users', Admin\Users\Index::class)->name('users.index'); // Route name: 'admin.users.index'
                Route::get('users/create', Admin\Users\Create::class)->name('users.create');
                Route::get('users/{user}/edit', Admin\Users\Edit::class)->name('users.edit');
                Route::get('users/{user}', Admin\Users\Show::class)->name('users.show');

                Route::get('roles', Admin\Roles\Index::class)->name('roles.index');
                Route::get('roles/create', Admin\Roles\Create::class)->name('roles.create');
                Route::get('roles/{role}/edit', Admin\Roles\Edit::class)->name('roles.edit');
            }
        );
});
