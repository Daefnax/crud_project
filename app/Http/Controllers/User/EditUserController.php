<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;

class EditUserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id, ['information']);

        $this->authorize('update', $user);

        return view('edit_user', compact('user'));
    }
}
