<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function show(?int $id = null)
    {
        $targetUser = Auth::user();

        if (!($targetUser instanceof User)) {
            abort(403);
        }

        $user = $id ? $this->userService->getUserById($id) : $targetUser;

        if (!$this->userService->canEdit($targetUser, $user)) {
            abort(403, 'Доступ к настройкам аккаунта запрещён.');
        }

        return view('security', ['targetUser' => $user]);
    }
}
