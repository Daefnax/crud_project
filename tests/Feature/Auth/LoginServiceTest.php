<?php

namespace Tests\Feature\Auth;

use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Services\Auth\LoginService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginServiceTest extends TestCase
{
    use RefreshDatabase;

    private LoginService $loginService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loginService = app(LoginService::class);
    }

    public function test_login_service_returns_true_for_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $result = $this->loginService->login([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertTrue($result);
    }

    public function test_login_service_throws_exception_on_invalid_credentials(): void
    {
        $this->expectException(ValidationException::class);

        $this->loginService->login([
            'email' => 'invalid@example.com',
            'password' => 'wrong-password',
        ]);
    }
}
