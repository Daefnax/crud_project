<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UsersPageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function authenticated_user_can_see_users_page(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/users')
            ->assertOk()
            ->assertViewIs('users')
            ->assertViewHas('users');
    }

    #[Test]
    public function only_admin_sees_add_button(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $nonAdmin = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin);
        $this->get('/users')->assertSee('Добавить');

        $this->actingAs($nonAdmin);
        $this->get('/users')->assertDontSee('Добавить');
    }

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $this->get('/users')->assertRedirect('/login');
    }
}
