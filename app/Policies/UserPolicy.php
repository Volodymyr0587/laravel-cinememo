<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
     /**
     * Determine whether the user can view the list of users.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_users') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can view a specific user.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('view_users') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can create users.
     */
    public function create(User $user): bool
    {
        return $user->can('create_users') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can update a user.
     */
    public function update(User $user, User $model): bool
    {
        return $user->can('edit_users') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can delete a user.
     */
    public function delete(User $user, User $model): bool
    {
        // Prevent self-deletion
        if ($user->id === $model->id) {
            return false;
        }

        // Prevent deletion of super admins
        if ($model->hasRole('super_admin')) {
            return false;
        }

        // Only super admins can delete other admins
        if ($model->hasRole('admin') && !$user->hasRole('super_admin')) {
            return false;
        }

        // Ensure at least one admin remains
        if ($model->hasRole('admin')) {
            $adminCount = User::role(['admin', 'super_admin'])->count();
            if ($adminCount <= 1) {
                return false;
            }
        }

        return $user->can('delete_users') && ($user->hasRole('admin') || $user->hasRole('super_admin'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->can('edit_users') && $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->can('delete_users') && $user->hasRole('admin');
    }
}
