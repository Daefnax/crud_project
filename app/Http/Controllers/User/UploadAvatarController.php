<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAvatarRequest;
use App\Services\UserService;
use App\Services\AvatarService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UploadAvatarController extends Controller
{
    public function __construct(
        private UserService   $userService,
        private AvatarService $avatarService
    )
    {
    }

    public function showForm(int $id = null)
    {
        $user = $this->userService->getUserById($id ?? auth()->id());

        $this->authorize('update', $user);

        $avatarUrl = $this->avatarService->getAvatarUrl($user);

        return view('users.avatar', compact('avatarUrl', 'user'));
    }

    public function upload(UploadAvatarRequest $request, int $id = null)
    {
        $user = $this->userService->getUserById($id ?? auth()->id());

        $this->authorize('update', $user);

        try {
            $this->avatarService->upload($user, $request->file('image'));

            return redirect()->route('upload.avatar.form', ['id' => $user->id])
                ->with('success', 'Аватар успешно загружен.');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['error' => 'Ошибка загрузки: ' . $e->getMessage()]);
        }
    }

}
