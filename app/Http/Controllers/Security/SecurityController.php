<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

class SecurityController extends Controller
{
    public function show(User $user)
    {
        $user = $user ?? auth()->user();

        $this->authorize('update', $user);

        return view('users.security', ['targetUser' => $user]);
    }
}
