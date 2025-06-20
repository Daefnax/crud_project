<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UpdateUserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->userService->getUserById($id);

        $this->authorize('update', $user);

        $this->userService->updateInfo($user, $request->validated());

        return redirect()->route('users')->with('success', 'Данные успешно обновлены.');

    }
}
