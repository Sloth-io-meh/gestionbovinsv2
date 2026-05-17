<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tansporteur;

class TansporteurPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Tansporteur $tansporteur): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Tansporteur $tansporteur): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Tansporteur $tansporteur): bool
    {
        return $user->is_admin;
    }
}
