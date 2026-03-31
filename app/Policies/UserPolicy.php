<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) return true;
        if ($user->isAdmin() && $model->role === 'peminjam') return true;
        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) return true;
        if ($user->isAdmin() && $model->role === 'peminjam') return true;
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        if ($user->isSuperAdmin()) return true;
        if ($user->isAdmin() && $model->role === 'peminjam') return true;
        return false;
    }
}
