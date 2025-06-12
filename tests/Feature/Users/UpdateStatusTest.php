<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateStatusTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_update_own_status(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('update.status'), [
            'status' => 'away',
        ]);

        $response->assertRedirect(route('status', ['id' => $user->id]));
        $this->assertDatabaseHas('user_media', [
            'user_id' => $user->id,
            'status' => 'away',
        ]);
    }

    #[Test]
    public function admin_can_update_other_user_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin);

        $response = $this->post(route('update.status'), [
            'status' => 'do_not_disturb',
            'user_id' => $user->id,
        ]);

        $response->assertRedirect(route('status', ['id' => $user->id]));
        $this->assertDatabaseHas('user_media', [
            'user_id' => $user->id,
            'status' => 'do_not_disturb',
        ]);
    }

    #[Test]
    public function user_cannot_update_other_users_status(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('update.status'), [
            'status' => 'online',
            'user_id' => $other->id,
        ]);

        $response->assertStatus(403);
    }

    #[Test]
    public function status_must_be_valid(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('update.status'), [
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors(['status']);
    }
}
