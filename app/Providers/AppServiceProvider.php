<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('dashboard', function ($view) {

            $user = auth()->user();

            $view->with([
                'contentItemsCount' => $user->contentItems()->count(),
                'lastUpdatedContentItem' =>  $user->contentItems()
                    ->orderBy('content_items.updated_at', 'desc')
                    ->select('content_items.title', 'content_items.updated_at')
                    ->first(),
                'contentTypesCount' =>$user->contentTypes()->count(),
                'lastUpdatedContentType' => $user->contentTypes()
                    ->latest('updated_at')
                    ->select('name', 'updated_at')
                    ->first(),
            ]);
        });
    }
}
