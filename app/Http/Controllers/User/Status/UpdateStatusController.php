<?php

namespace App\Http\Controllers\User\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\User;
use App\Services\UserService;

class UpdateStatusController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function update(UpdateStatusRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user = User::findOrFail($user->id);

        $this->userService->updateStatus($user, $request->input('status'));

        return redirect()->route('users.index')
            ->with('success', 'Статус успешно обновлён.');
    }
}
