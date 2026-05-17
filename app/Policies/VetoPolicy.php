<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Veto;

class VetoPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Veto $veto): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Veto $veto): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Veto $veto): bool
    {
        return $user->is_admin;
    }
}
