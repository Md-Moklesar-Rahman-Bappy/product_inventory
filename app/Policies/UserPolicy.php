<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperadmin();
    }

    public function view(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->isSuperadmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperadmin();
    }

    public function update(User $user, User $model): bool
    {
        if ($user->isSuperadmin()) {
            return true;
        }
        if ($user->isAdmin() && ! $model->isSuperadmin()) {
            return true;
        }

        return false;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->isSuperadmin() && $user->id !== $model->id) {
            return true;
        }
        if ($user->isAdmin() && ! $model->isAdmin() && ! $model->isSuperadmin()) {
            return true;
        }

        return false;
    }

    public function restore(User $user): bool
    {
        return $user->isSuperadmin();
    }

    public function forceDelete(User $user): bool
    {
        return $user->isSuperadmin();
    }

    public function toggleStatus(User $user, User $model): bool
    {
        return $user->isSuperadmin() && $user->id !== $model->id;
    }
}
