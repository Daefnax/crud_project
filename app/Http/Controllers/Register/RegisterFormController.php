<?php

namespace App\Http\Controllers\Register;


use App\Http\Controllers\Controller;

class RegisterFormController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
}
