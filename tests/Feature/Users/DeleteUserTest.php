<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function actingAsAdmin(): User
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        return $admin;
    }

    public function actingAsUser(): User
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);
        return $user;
    }
    #[Test]
    public function user_can_delete_own_account(): void
    {
        $user = $this->actingAsUser();

        $this->actingAs($user);

        $response = $this->delete(route('users.destroy', $user->id));

        $response->assertRedirect('login');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function admin_can_delete_other_user(): void
    {
        $this->actingAsAdmin();
        $target = User::factory()->create();

        $response = $this->delete(route('users.destroy', $target->id));

        $response->assertRedirect(route('users.index'));
        $this->assertSoftDeleted('users', ['id' => $target->id]);
    }

    #[Test]
    public function user_cannot_delete_other_user(): void
    {
        $user = $this->actingAsUser();
        $other = User::factory()->create();

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
