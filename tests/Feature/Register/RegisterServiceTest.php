<?php

namespace Tests\Feature\Register;

use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterServiceTest extends TestCase
{
    use RefreshDatabase;

    private RegisterService $registerService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registerService = app()->make(RegisterService::class);
    }

    public function test_register_service_creates_user(): void
    {
        $data = [
            'email' => 'new@example.com',
            'password' => 'password'
        ];

        $user = $this->registerService->register($data);

        $this->assertInstanceOf(User::class, $user);

        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
    }

    public function test_register_service_rejects_duplicate_email(): void
    {
        User::factory()->create([
            'email' => 'taken@example.com',
        ]);

        $this->expectException(\Exception::class);

        $this->registerService->register([
            'email' => 'taken@example.com',
            'password' => 'password'
        ]);
    }
}
