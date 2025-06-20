<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request->search);
        $isAdmin = Auth::user()?->can('admin');

        return view('users.index', compact('users', 'isAdmin'));
    }
}
