<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadAvatarRequest;
use App\Models\User;
use App\Services\AvatarService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AvatarFormController extends Controller
{
    public function __construct(private AvatarService $avatarService)
    {
    }

    public function showForm(User $user): View
    {
        $this->authorize('update', $user);

        $avatarUrl = $this->avatarService->getAvatarUrl($user);

        return view('users.avatar', compact('avatarUrl', 'user'));
    }

}
