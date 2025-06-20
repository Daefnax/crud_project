<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function show(Request $request, ?int $id = null)
    {
        $user = $this->userService->getUserById($id ?? auth()->id());

        $this->authorize('view', $user);

        $current_status = $user->media->status ?? '';

        return view('users.status', [
            'targetUser' => $user,
            'current_status' => $current_status,
        ]);
    }
}
