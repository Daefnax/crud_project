<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;

class CreateUserService
{
    public function __construct(private AvatarService $avatarService)
    {
    }

    public function createUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? 'user',
            ]);

            $user->information()->create([
                'username' => $data['username'] ?? '',
                'job_title' => $data['job_title'] ?? '',
                'phone' => $data['phone'] ?? '',
                'address' => $data['address'] ?? '',
            ]);

            $user->socials()->create([
                'vk' => $data['vk'] ?? null,
                'telegram' => $data['telegram'] ?? null,
                'instagram' => $data['instagram'] ?? null,
            ]);

            $user->media()->create([
                'status' => $data['status'] ?? 'online',
                'image' => null
            ]);

            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->avatarService->upload($user, $data['image']);
            }

            return $user;
        });
    }
}
