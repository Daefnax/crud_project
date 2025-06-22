<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $users = $this->userService->getAllUsers($request->search);

        $isAdmin = auth()->user()?->role === 'admin';

        return view('users.index', compact('users', 'isAdmin'));
    }
}
