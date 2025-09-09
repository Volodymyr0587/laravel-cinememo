<?php

namespace App\Services;

use App\Models\User;
use App\Models\Genre;
use App\Models\ContentItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    /**
     * Get recommendations for a given user.
     */
    public function getRecommendationsForUser(User $user): Collection
    {
        return Cache::remember(
            "user:{$user->id}:recommendations",
            now()->addHours(6), // cache lifetime
            fn () => $this->buildRecommendations($user)
        );
    }

    /**
     * Rebuild and refresh cache for a given user.
     */
    public function refreshRecommendationsForUser(User $user): Collection
    {
        $recommendations = $this->buildRecommendations($user);

        Cache::put("user:{$user->id}:recommendations", $recommendations, now()->addHours(6));

        return $recommendations;
    }

    /**
     * Internal logic for building recommendations.
     */
    protected function buildRecommendations(User $user): Collection
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
                $q->whereIn('genres.id', $topGenres->pluck('id'));
            })
            ->whereNotIn('id', $user->contentItems()->pluck('id'))
            ->whereNotIn('title', $user->contentItems()->pluck('title'))
            ->with('genres')
            ->inRandomOrder()
            ->take(6)
            ->get();

        return collect([
            'genres' => $topGenres,
            'recommendations' => $recommendations,
        ]);
    }

}
