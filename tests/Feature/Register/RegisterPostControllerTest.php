<?php

namespace Tests\Feature\Register;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterPostControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_register_successfully()
    {
        $response = $this->post('register', [
            'email' => 'newuser@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('login');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);
        $response->assertSessionHas('success', 'Вы зарегистрированы!');
    }

    public function test_email_must_be_unique_on_registration()
    {
        User::factory()->create([
            'email' => 'taken@example.com'
        ]);
        $response = $this->post('register', [
            'email' => 'taken@example.com',
            'password' => 'password',
        ]);
        $response->assertSessionHasErrors('email');
    }
}
