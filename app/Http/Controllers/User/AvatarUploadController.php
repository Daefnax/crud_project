<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAvatarRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AvatarUploadController extends Controller
{
    public function __construct(private AvatarService $avatarService)
    {
    }

    public function upload(UploadAvatarRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        try {
            $this->avatarService->upload($user, $request->file('image'));
            return redirect()->route('users.profile', $user)
                ->with('success', 'Аватар успешно загружен.');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['error' => 'Ошибка загрузки: ' . $e->getMessage()]);
        }
    }

}
