<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateSecurityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_cannot_update_security(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('security.update'), [
            'user_id' => $user->id,
            'email' => 'hacker@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function user_can_update_own_security(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('security.update'), [
            'email' => 'new' . $user->id . '@example.com',
            'password' => 'newpassword123',
        ]);

        $response->assertRedirect(route('users.security', ['user' => $user->id]));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'new' . $user->id . '@example.com']);
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    #[Test]
    public function admin_can_update_other_user_security(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->post(route('security.update'), [
            'user_id' => $user->id,
            'email' => 'other' . $user->id . '@example.com',
            'password' => 'securepass456',
        ]);

        $response->assertRedirect(route('users.security', ['user' => $user->id]));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'other' . $user->id . '@example.com']);
        $this->assertTrue(Hash::check('securepass456', $user->fresh()->password));
    }

    #[Test]
    public function user_cannot_update_other_user_security(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('security.update'), [
            'user_id' => $otherUser->id,
            'email' => 'unauthorized@example.com',
            'password' => 'unauthpass1',
        ]);

        $response->assertForbidden();
    }

    #[Test]
    public function invalid_data_throws_errors(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('security.update'), [
            'email' => 'not-an-email',
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
    }
}
