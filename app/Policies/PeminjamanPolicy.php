<?php

namespace App\Policies;

use App\Models\User;

class PeminjamanPolicy
{
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        if ($user->isAdmin()) return true;
        return $user->id === $peminjaman->id_user;
    }

    public function create(User $user): bool
    {
        return $user->isPeminjam() && !$user->is_banned;
    }

    public function approve(User $user, Peminjaman $peminjaman): bool
    {
        return $user->isAdmin() && $peminjaman->canBeApproved();
    }

    public function reject(User $user, Peminjaman $peminjaman): bool
    {
        return $user->isAdmin() && $peminjaman->canBeRejected();
    }

    public function handOver(User $user, Peminjaman $peminjaman): bool
    {
        return $user->isAdmin() && $peminjaman->canBeHandedOver();
    }

    public function return(User $user, Peminjaman $peminjaman): bool
    {
        return $user->isAdmin() && $peminjaman->canBeReturned();
    }
}
