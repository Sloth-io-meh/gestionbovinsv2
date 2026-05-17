<?php

namespace App\Policies;

use App\Models\Visite;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class VisitePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Visite $visite): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Visite $visite): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Visite $visite): bool
    {
        return $user->is_admin;
    }
}
