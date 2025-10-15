<?php

use App\Livewire\Admin;
use App\Livewire\Articles;
use App\Models\User;
use Spatie\Permission\Models\Role;

Route::middleware(['auth', 'role:admin|super_admin'])->group(function () {
     Route::prefix('admin') // Adds '/admin' to the URL of all routes in this group
        ->name('admin.') // Prefixes route names with 'admin.'
        ->group(
            function () {
                Route::get('users', Admin\Users\Index::class)
                    ->middleware('can:viewAny,' . User::class)
                    ->name('users.index'); // Route name: 'admin.users.index'
                Route::get('users/create', Admin\Users\Create::class)
                    ->middleware('can:create,' . User::class)
                    ->name('users.create');
                Route::get('users/{user}/edit', Admin\Users\Edit::class)
                    ->middleware('can:update,user')
                    ->name('users.edit');
                Route::get('users/{user}', Admin\Users\Show::class)
                    ->middleware('can:view,user')
                    ->name('users.show');

                Route::get('roles', Admin\Roles\Index::class)
                    ->middleware('can:viewAny,' . Role::class)
                    ->name('roles.index');
                Route::get('roles/create', Admin\Roles\Create::class)
                    ->middleware('can:create,' . Role::class)
                    ->name('roles.create');
                Route::get('roles/{role}/edit', Admin\Roles\Edit::class)
                    ->middleware('can:update,role')
                    ->name('roles.edit');

                Route::get('articles/deleted', Articles\Deleted::class)->name('articles.deleted');

                Route::get('genres', Admin\Genres\Index::class)->name('genres.index'); // Route name: 'admin.genres.index'
                Route::get('genres/create', Admin\Genres\Create::class)->name('genres.create');
                Route::get('genres/{genre}/edit', Admin\Genres\Edit::class)->name('genres.edit');
                Route::get('genres/{genre}', Admin\Genres\Show::class)->name('genres.show');

                Route::get('professions', Admin\Professions\Index::class)->name('professions.index'); // Route name: 'admin.professions.index'
                Route::get('professions/create', Admin\Professions\Create::class)->name('professions.create');
                Route::get('professions/{profession}/edit', Admin\Professions\Edit::class)->name('professions.edit');
                Route::get('professions/{profession}', Admin\Professions\Show::class)->name('professions.show');
            }
        );
});
