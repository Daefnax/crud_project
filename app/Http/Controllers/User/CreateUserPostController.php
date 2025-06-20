<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Services\CreateUserService;

class CreateUserPostController extends Controller
{
    public function store(CreateUserRequest $request, CreateUserService $service)
    {
        try {
            $validated = $request->validated();

            $service->createUser($validated);

            return redirect()->route('users.index');
        } catch (\Throwable $e) {
            report($e);

            return back()->withErrors(['error' => 'Что-то пошло не так: ' . $e->getMessage()]);
        }
    }
}
