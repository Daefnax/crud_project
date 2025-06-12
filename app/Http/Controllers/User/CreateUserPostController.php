<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Services\CreateUserService;
use Illuminate\Http\RedirectResponse;

class CreateUserPostController extends Controller
{
    public function __construct(private CreateUserService $createUserService)
    {
    }

    public function store(CreateUserRequest $request): RedirectResponse
    {
        try {
            $this->createUserService->createUser($request->validated());

            return redirect()->route('users')->with('success', 'Пользователь успешно добавлен.');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Ошибка при создании пользователя: ' . $e->getMessage()]);
        }
    }
}
