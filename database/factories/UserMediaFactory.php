<?php

namespace Database\Factories;

use App\Models\UserMedia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserMediaFactory extends Factory
{
    protected $model = UserMedia::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'image' => $this->faker->image('public/uploads', 640, 480, null, false),
        ];
    }
}
