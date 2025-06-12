<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class EditUserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id, ['information']);
        return view('edit_user', compact('user'));
    }
}
