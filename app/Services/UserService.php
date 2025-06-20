<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAllUsers(?string $search = null): Collection
    {
        return User::with('information')
            ->whereNull('deleted_at')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('information', function ($q) use ($search) {
                    $q->where('username', 'like', '%' . $search . '%');
                });
            })
            ->get();
    }

    public function getUserById(int $id, array $relations = []): User
    {
        return User::with($relations)->findOrFail($id);
    }

    public function deleteUser(User $user): bool
    {
        if (auth()->id() === $user->id) {
            return (bool) $user->forceDelete();
        }

        return (bool) $user->delete();
    }

    public function updateSecurity(User $user, array $data): void
    {
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
    }

    public function updateStatus(User $user, string $status): void
    {
        $media = $user->media()->firstOrCreate([]);
        $media->status = $status;
        $media->save();
    }

    public function updateInfo(User $user, array $data): void
    {
        $info = $user->information;
        if (!$info) {
            $user->information()->create([
                'username' => $data['username'] ?? '',
                'job_title' => $data['job_title'] ?? '',
                'phone' => $data['phone'] ?? '',
                'address' => $data['address'] ?? '',
            ]);
        } else {
            $info->update([
                'username' => $data['username'] ?? '',
                'job_title' => $data['job_title'] ?? '',
                'phone' => $data['phone'] ?? '',
                'address' => $data['address'] ?? '',
            ]);
        }

        $socials = $user->socials;
        if (!$socials) {
            $user->socials()->create([
                'vk' => $data['vk'] ?? null,
                'telegram' => $data['telegram'] ?? null,
                'instagram' => $data['instagram'] ?? null,
            ]);
        } else {
            $socials->update([
                'vk' => $data['vk'] ?? null,
                'telegram' => $data['telegram'] ?? null,
                'instagram' => $data['instagram'] ?? null,
            ]);
        }
    }

    public function canEdit(User $actor, User $target): bool
    {
        return $actor->id === $target->id || $actor->can('admin');
    }

}
