<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;

class UpdateUserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        $this->service->updateInfo($user, $request->validated());

        return redirect()->route('users.index')->with('success', 'Данные успешно обновлены.');

    }
}
