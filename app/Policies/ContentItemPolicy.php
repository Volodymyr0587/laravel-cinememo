<?php

namespace App\Policies;

use App\Models\ContentItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContentItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentItem $contentItem): bool
    {
        return $contentItem->is_public || $contentItem->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentItem $contentItem): bool
    {
         return $contentItem->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentItem $contentItem): bool
    {
        return $contentItem->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentItem $contentItem): bool
    {
        return $contentItem->user_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentItem $contentItem): bool
    {
        return $contentItem->user_id === $user->id;
    }

    public function like(User $user, ContentItem $contentItem): bool
    {
        return $contentItem->is_public && $contentItem->user_id !== $user->id;
    }

    /**
     * Determine whether the user can view actors of the content item.
     */
    public function viewActors(User $user, ContentItem $contentItem): bool
    {
        // Allow if item is not public
        if (!$contentItem->is_public) {
            return true;
        }

        // Allow if item is public but owned by the user
        if ($contentItem->is_public && $contentItem->user_id === $user->id) {
            return true;
        }

        // Otherwise, deny
        return false;
    }

    /**
     * Determine whether the user can view people of the content item.
     */
    public function viewPeople(User $user, ContentItem $contentItem): bool
    {
        // Allow if item is not public
        if (!$contentItem->is_public) {
            return true;
        }

        // Allow if item is public but owned by the user
        if ($contentItem->is_public && $contentItem->user_id === $user->id) {
            return true;
        }

        // Otherwise, deny
        return false;
    }
}
