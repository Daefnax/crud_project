<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UpdateStatusController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function update(UpdateStatusRequest $request)
    {
        $targetId = $request->input('user_id', Auth::id());

        $targetUser = $this->userService->getUserById($targetId);

        $authUser = Auth::user();

        if (!($authUser instanceof User)) {
            abort(403, 'Неверный тип пользователя');
        }

        if (!$this->userService->canEdit($authUser, $targetUser)) {
            abort(403, 'У вас нет прав на изменение статуса.');
        }

        $this->userService->updateStatus($targetUser, $request->input('status'));

        return Redirect::route('status', ['id' => $targetId])
            ->with('success', 'Статус успешно обновлён.');
    }
}
