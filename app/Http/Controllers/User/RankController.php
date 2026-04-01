<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public function index()
    {
        $rankings = User::where('role', 'peminjam')
            ->orderBy('points', 'desc')
            ->paginate(20);
        return view('user.rankings', compact('rankings'));
    }
}
