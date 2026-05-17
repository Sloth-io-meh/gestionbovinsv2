<?php

namespace App\Policies;

use App\Models\Meds;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedsPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Meds $meds): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Meds $meds): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Meds $meds): bool
    {
        return $user->is_admin;
    }
}
