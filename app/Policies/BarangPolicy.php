<?php

namespace App\Policies;

use App\Models\User;

class BarangPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }
    public function view(User $user, Barang $barang)
    {
        return $user->isAdmin();
    }
    public function create(User $user)
    {
        return $user->isAdmin();
    }
    public function update(User $user, Barang $barang)
    {
        return $user->isAdmin();
    }
    public function delete(User $user, Barang $barang)
    {
        return $user->isAdmin();
    }
}
