<?php

namespace App\Services;

use App\Models\User;

class ProfileService
{
    public function getUserById(int $id)
    {
        return User::with(['information', 'media', 'socials'])->findOrFail($id);
    }
}
