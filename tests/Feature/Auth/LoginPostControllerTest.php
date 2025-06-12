<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginPostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('users'));
        $this->assertAuthenticatedAs($user);
        $response->assertSessionHas('success', 'Вы вошли.');
    }

    public function test_login_requires_csrf_token()
    {
        $response = $this->from('login')->post('login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('login');
        $this->assertGuest();
    }
}
