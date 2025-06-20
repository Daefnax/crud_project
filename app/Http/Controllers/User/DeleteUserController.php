<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DeleteUserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function destroy(int $id)
    {
        $user = $this->userService->getUserById($id);

        $this->authorize('delete', $user); // проверка прав через policy

        $isSelf = auth()->id() === $user->id;

        $this->userService->deleteUser($user);

        if ($isSelf) {
            auth()->logout();
            return redirect()->route('login')->with('success', 'Ваш профиль успешно удалён.');
        }

        return redirect()->route('users')->with('success', 'Пользователь успешно удалён.');
    }

}
