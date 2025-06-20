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
        $userId = $request->input('user_id', auth()->id());
        $user = $this->userService->getUserById($userId);

        $this->authorize('update', $user);

        $this->userService->updateSecurity($user, $request->validated());

        return redirect()->route('security', ['id' => $user->id])
            ->with('success', 'Email и пароль успешно обновлены.');
    }
}
