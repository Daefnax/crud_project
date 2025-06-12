<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_delete_own_account(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->delete(route('users.destroy', $user->id));

        $response->assertRedirect('/login');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function admin_can_delete_other_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin);

        $response = $this->delete(route('users.destroy', $user->id));

        $response->assertRedirect(route('users'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function user_cannot_delete_other_user(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user);

        $response = $this->delete(route('users.destroy', $other->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $other->id]);
    }

    #[Test]
    public function guest_cannot_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user->id));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
