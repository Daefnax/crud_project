<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class EditUserController extends Controller
{
    public function show(User $user): View
    {
        $this->authorize('update', $user);

        $user->load('information');

        return view('users.edit', compact('user'));
    }
}
