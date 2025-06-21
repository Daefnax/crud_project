<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAvatarRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UploadAvatarController extends Controller
{
    public function __construct(private AvatarService $avatarService)
    {
    }

    public function showForm(?User $user = null): View
    {
        $this->authorize('update', $user);

        $avatarUrl = $this->avatarService->getAvatarUrl($user);

        return view('users.avatar', compact('avatarUrl', 'user'));
    }

    public function upload(UploadAvatarRequest $request, ?User $user = null): RedirectResponse
    {
        $user = $user ?? auth()->user();
        $this->authorize('update', $user);

        try {
            $this->avatarService->upload($user, $request->file('image'));
            return redirect()->route('users.profile', ['id' => $user->id])
                ->with('success', 'Аватар успешно загружен.');
        } catch (\Throwable $e) {
            return redirect()->back()->withErrors(['error' => 'Ошибка загрузки: ' . $e->getMessage()]);
        }
    }

}
