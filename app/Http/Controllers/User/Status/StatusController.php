<?php

namespace App\Http\Controllers\User\Status;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function show(?User $user = null)
    {
        $user = $user ?? auth()->user();

        $this->authorize('view', $user);

        $user->load('media');

        return view('users.status', [
            'user' => $user,
            'currentStatus' => $user->media?->status ?? 'available'
        ]);
    }
}
