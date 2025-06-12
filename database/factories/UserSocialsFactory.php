<?php

namespace Database\Factories;

use App\Models\UserSocials;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSocialsFactory extends Factory
{
    protected $model = UserSocials::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'vk' => $this->faker->url,
            'telegram' => 'https://t.me/' . $this->faker->userName,
            'instagram' => 'https://instagram.com/' . $this->faker->userName,
        ];
    }
}
