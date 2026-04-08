<?php

namespace App\Policies;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BrandPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Brand $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperadmin();
    }

    public function update(User $user, Brand $model): bool
    {
        return $user->isAdmin() || $user->isSuperadmin();
    }

    public function delete(User $user, Brand $model): bool
    {
        return $user->isSuperadmin();
    }

    public function restore(User $user): bool
    {
        return $user->isSuperadmin();
    }

    public function forceDelete(User $user): bool
    {
        return $user->isSuperadmin();
    }
}
