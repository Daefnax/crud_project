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

        $this->get(route('users.index'))
            ->assertOk()
            ->assertViewIs('users.index')
            ->assertViewHas('users');
    }

    #[Test]
    public function only_admin_sees_add_button(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $nonAdmin = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin);
        $this->get(route('users.index'))->assertSee('data-test="add-user-btn"', false);

        $this->actingAs($nonAdmin);
        $this->get(route('users.index'))->assertDontSee('data-test="add-user-btn"', false);
    }

    #[Test]
    public function guests_are_redirected_to_login(): void
    {
        $this->get(route('users.index'))->assertRedirect(route('login'));
    }
}
