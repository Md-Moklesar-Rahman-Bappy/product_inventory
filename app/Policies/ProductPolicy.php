<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isUser() || $user->isAdmin() || $user->isSuperadmin();
    }

    public function view(User $user, Product $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isSuperadmin();
    }

    public function update(User $user, Product $model): bool
    {
        return $user->isAdmin() || $user->isSuperadmin();
    }

    public function delete(User $user, Product $model): bool
    {
        return $user->isAdmin() || $user->isSuperadmin();
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
