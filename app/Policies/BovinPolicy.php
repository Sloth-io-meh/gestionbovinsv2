<?php

namespace App\Policies;

use App\Models\Bovin;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BovinPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Bovin $bovin): bool
    {
        return true; // All authenticated users can view details
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->is_admin; // Only admins can create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Bovin $bovin): bool
    {
        return $user->is_admin; // Only admins can update
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Bovin $bovin): bool
    {
        return $user->is_admin; // Only admins can delete
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Bovin $bovin): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Bovin $bovin): bool
    {
        return $user->is_admin;
    }
}
