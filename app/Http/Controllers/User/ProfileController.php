<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profileService)
    {
    }

    public function show(?int $id = null)
    {
        $userId = $id ?? Auth::id();

        $user = $this->profileService->getUserById($userId);

        return view('profile', ['user' => $user]);
    }

}
