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
        // Get user's top 5 genres (models, so we can display names later)
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
            ->get();

        // Get recommendations
        $recommendations = ContentItem::query()
            ->where('is_public', true) // only public
            ->whereHas('genres', function ($q) use ($topGenres) {
                $q->whereIn('genres.id', $topGenres->pluck('id')); // only IDs
            })
            ->whereNotIn('id', $user->contentItems()->pluck('id'))
            ->whereNotIn('title', $user->contentItems()->pluck('title'))
            ->with('genres')
            ->inRandomOrder()
            ->take(6)
            ->get();

        return collect([
            'genres' => $topGenres,          // full models for names
            'recommendations' => $recommendations,
        ]);
}

}
