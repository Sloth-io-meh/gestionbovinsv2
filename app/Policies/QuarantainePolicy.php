<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quarantaine;

class QuarantainePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Quarantaine $quarantaine): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Quarantaine $quarantaine): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Quarantaine $quarantaine): bool
    {
        return $user->is_admin;
    }
}
