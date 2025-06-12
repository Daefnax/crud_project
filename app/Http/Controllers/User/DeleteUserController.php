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
        $currentUser = Auth::user();

        try {
            $user = $this->userService->getUserById($id);

            if ($currentUser->id !== $user->id && !$currentUser->can('admin')) {
                abort(403, 'У вас нет прав на удаление этого пользователя');
            }

            $isSelfDelete = $currentUser->id === $user->id;

            $this->userService->deleteUser($user);

            if ($isSelfDelete) {
                Auth::logout();
                return Redirect::to('login')->with('success', 'Ваш профиль успешно удален.');
            }

            return Redirect::route('users')->with('success', 'Пользователь успешно удален.');
        } catch (HttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return Redirect::back()->withErrors(['error' => 'Ошибка при удалении пользователя.']);
        }
    }
}
