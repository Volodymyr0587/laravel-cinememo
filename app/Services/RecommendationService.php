<?php

namespace App\Services;

use App\Models\User;
use App\Models\Genre;
use App\Models\ContentItem;
use Illuminate\Support\Collection;

class RecommendationService
{
    public function getRecommendationsForUser(User $user): Collection
    {
        //% Get user's top 5 genres
        $topGenres = Genre::whereHas('contentItems', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->withCount([
                'contentItems as total' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                }
            ])
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('id');


        //% Get recommendations
        return ContentItem::query()
            ->where('is_public', true) // only public
            ->whereHas('genres', function ($q) use ($topGenres) {
                $q->whereIn('genres.id', $topGenres);
            })
            ->whereNotIn('id', $user->contentItems()->pluck('id')) // exclude owned
            ->whereNotIn('title', $user->contentItems()->pluck('title')) // avoid same title
            ->with('genres')
            ->inRandomOrder()
            ->take(6)
            ->get();
    }
}
