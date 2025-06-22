<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $authUser, User $targetUser) : bool
    {
        return true;
    }

    public function viewAny(User $authUser) : bool
    {
        return true;
    }

    public function update(User $authUser, User $targetUser): bool
    {
        return $authUser->id === $targetUser->id || $authUser->hasRole('admin');
    }

    public function delete(User $authUser, User $targetUser) : bool
    {
        return $authUser->id === $targetUser->id || $authUser->hasRole('admin');
    }

    public function create(User $authUser) : bool
    {
        return $authUser->hasRole('admin');
    }
}
