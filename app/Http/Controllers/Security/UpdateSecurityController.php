<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSecurityRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UpdateSecurityController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function update(UpdateSecurityRequest $request)
    {
        $authUser = Auth::user();

        if (!($authUser instanceof User)) {
            abort(403);
        }

        $targetId = $request->input('user_id', $authUser->id);
        $targetUser = $this->userService->getUserById($targetId);

        if (!$this->userService->canEdit($authUser, $targetUser)) {
            abort(403, 'Вы не можете изменить email или пароль другого пользователя.');
        }

        $this->userService->updateSecurity($targetUser, $request->validated());

        return Redirect::route('security', ['id' => $targetUser->id])
            ->with('success', 'Email и пароль успешно обновлены.');
    }
}
