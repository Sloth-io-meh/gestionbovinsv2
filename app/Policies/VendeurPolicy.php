<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendeur;

class VendeurPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Vendeur $vendeur): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Vendeur $vendeur): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Vendeur $vendeur): bool
    {
        return $user->is_admin;
    }
}
