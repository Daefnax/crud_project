<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class LoginFormController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }
}
