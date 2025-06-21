<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CreateUserFormController extends Controller
{
    public function create(): View
    {
        return view('users.create');
    }
}
