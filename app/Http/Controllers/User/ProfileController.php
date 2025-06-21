<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        $user->load('information', 'socials', 'media');

        return view('users.profile', compact('user'));
    }

}
