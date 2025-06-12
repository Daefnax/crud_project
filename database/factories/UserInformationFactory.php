<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInformationFactory extends Factory
{
    protected $model = UserInformation::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->userName,
            'job_title' => $this->faker->jobTitle,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'user_id' => User::factory(),
        ];
    }
}
