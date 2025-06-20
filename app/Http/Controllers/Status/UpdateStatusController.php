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
        $user = $this->userService->getUserById($request->input('user_id', auth()->id()));

        $this->authorize('update', $user);

        $this->userService->updateStatus($user, $request->input('status'));

        return redirect()->route('status', ['id' => $user->id])
            ->with('success', 'Статус успешно обновлён.');
    }
}
