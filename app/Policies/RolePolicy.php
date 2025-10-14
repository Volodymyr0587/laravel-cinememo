<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
     /**
     * Determine whether the user can view roles.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_roles') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can view a specific role.
     */
    public function view(User $user, Role $role): bool
    {
        return $user->can('view_roles') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can create roles.
     */
    public function create(User $user): bool
    {
        return $user->can('create_roles') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can update a role.
     */
    public function update(User $user, Role $role): bool
    {
        // Prevent editing of the super_admin role by anyone except super_admin
        if ($role->name === 'super_admin' && !$user->hasRole('super_admin')) {
            return false;
        }

        return $user->can('edit_roles') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can delete a role.
     */
    public function delete(User $user, Role $role): bool
    {
        // Prevent deleting the super_admin role entirely
        if ($role->name === 'super_admin') {
            return false;
        }

        // Prevent deleting own role (if user has this role)
        if ($user->hasRole($role->name)) {
            return false;
        }

        return $user->can('delete_roles') && $user->hasRole(['admin', 'super_admin']);
    }

    /**
     * Determine whether the user can assign permissions to roles.
     */
    public function assignPermissions(User $user): bool
    {
        return $user->can('assign_permissions_to_roles') && $user->hasRole(['admin', 'super_admin']);
    }
}
