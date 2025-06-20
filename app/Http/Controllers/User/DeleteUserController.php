<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

class DeleteUserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $isSelf = auth()->id() === $user->id;

        $deleted = $this->service->deleteUser($user);

        if (!$deleted) {
            return back()->with('error', 'Не удалось удалить пользователя.');
        }

        if ($isSelf) {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Ваш профиль успешно удалён.');
        }

        return redirect()->route('users.index')->with('success', 'Пользователь успешно удалён.');
    }
}
