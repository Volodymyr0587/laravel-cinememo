<?php

namespace App\Observers;

use App\Models\ContentItem;
use App\Services\RecommendationService;

class ContentItemObserver
{
    /**
     * Handle the ContentItem "created" event.
     */
    public function created(ContentItem $contentItem): void
    {
        //
    }

    /**
     * Handle the ContentItem "updated" event.
     */
    public function updated(ContentItem $contentItem): void
    {
        //
    }

     /**
     * Clear cache when a content item is created/updated.
     */
    public function saved(ContentItem $contentItem): void
    {
        $this->clearUserRecommendations($contentItem);
    }

    /**
     * Handle the ContentItem "deleted" event.
     */
    public function deleted(ContentItem $contentItem): void
    {
        $this->clearUserRecommendations($contentItem);
    }

    /**
     * Clear cache when genres are attached.
     */
    public function pivotAttached(ContentItem $contentItem, string $relation, array $ids): void
    {
        if ($relation === 'genres') {
            $this->clearUserRecommendations($contentItem);
        }
    }

    /**
     * Clear cache when genres are detached.
     */
    public function pivotDetached(ContentItem $contentItem, string $relation, array $ids): void
    {
        if ($relation === 'genres') {
            $this->clearUserRecommendations($contentItem);
        }
    }

    /**
     * Clear cache when genres are synced (replaced).
     */
    public function pivotSynced(ContentItem $contentItem, string $relation, array $changes): void
    {
        if ($relation === 'genres') {
            $this->clearUserRecommendations($contentItem);
        }
    }

    /**
     * Helper method to clear cache for a given user.
     */
    protected function clearUserRecommendations(ContentItem $contentItem): void
    {
        if ($contentItem->user_id) {
            app(RecommendationService::class)->refreshRecommendationsForUser($contentItem->user);
        }
    }

    /**
     * Handle the ContentItem "restored" event.
     */
    public function restored(ContentItem $contentItem): void
    {
        //
    }

    /**
     * Handle the ContentItem "force deleted" event.
     */
    public function forceDeleted(ContentItem $contentItem): void
    {
        //
    }
}
