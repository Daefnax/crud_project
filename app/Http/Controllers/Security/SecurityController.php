<?php

namespace App\Http\Controllers\Security;

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
        $user = $id ? $this->userService->getUserById($id) : auth()->user();

        $this->authorize('update', $user); // Policy проверка

        return view('users.security', ['targetUser' => $user]);
    }
}
