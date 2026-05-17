<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Etable;
use Illuminate\Auth\Access\Response;

class EtablePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Etable $etable): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Etable $etable): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Etable $etable): bool
    {
        return $user->is_admin;
    }
}
