<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicule;

class VehiculePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Vehicule $vehicule): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Vehicule $vehicule): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Vehicule $vehicule): bool
    {
        return $user->is_admin;
    }
}
