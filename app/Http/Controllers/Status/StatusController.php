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
        $targetId = $id ?? Auth::id();
        $user = $this->userService->getUserById($targetId);

        if ($user->id !== Auth::id() && !Auth::user()->can('admin')) {
            abort(403);
        }

        $current_status = $user->media->status ?? '';

        return view('status', [
            'targetUser' => $user,
            'current_status' => $current_status,
        ]);
    }
}
