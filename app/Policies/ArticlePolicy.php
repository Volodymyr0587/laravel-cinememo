<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // anyone can see articles
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        if ($article->is_published) {
            return true;
        }

        if ($user) {
            return $article->user->is($user) || $user->hasRole(['admin','super_admin', 'writer']);
        }
    }

    /**
     * Only users with 'writer' role can create articles.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['super_admin', 'writer']);
    }

    /**
     * Only the author, admin, super_admin can update article.
     */
    public function update(User $user, Article $article): bool
    {
        if ($user->hasAnyRole(['admin', 'super_admin'])) {
            return true;
        }

        return $article->user->is($user) && $user->hasRole(['writer']);
    }

    /**
     * Only admin or super_admin can delete any article.
     */
    public function delete(User $user, Article $article): bool
    {
         return $user->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool
    {
        return $user->hasAnyRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return $user->hasAnyRole(['admin', 'super_admin']);
    }
}
