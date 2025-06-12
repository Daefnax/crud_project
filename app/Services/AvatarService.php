<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class AvatarService
{
    public function upload(User $user, UploadedFile $file): void
    {
        $this->deleteOldAvatar($user);

        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        $media = $user->media()->firstOrCreate([]);
        $media->image = $filename;
        $media->save();
    }

    public function deleteOldAvatar(User $user): void
    {
        $oldImage = $user->media?->image;

        if ($oldImage && file_exists(public_path('uploads/' . $oldImage))) {
            unlink(public_path('uploads/' . $oldImage));
        }
    }

    public function getAvatarUrl(User $user): string
    {
        $file = $user->media?->image;

        return $file ? asset('uploads/' . $file) : asset('uploads/avatar-m.png');
    }
}
