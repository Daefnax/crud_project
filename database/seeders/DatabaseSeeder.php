<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ]);

        UserInformation::create([
            'user_id' => $user->id,
            'username' => 'test_user',
            'job_title' => 'Developer',
            'phone' => '+79123456789',
            'address' => 'Москва, ул. Ленина, д. 1'
        ]);
    }
}
