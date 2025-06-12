<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class CreateUserFormController extends Controller
{
    public function create()
    {
        return view('create_user');
    }
}
