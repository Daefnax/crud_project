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

        $response = $this->post(route('update.status', $user), [
            'status' => 'away',
        ]);

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'Статус успешно обновлён.');
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

        $response = $this->post(route('update.status', $user), [
            'status' => 'do_not_disturb',
        ]);

        $response->assertRedirect(route('users.index'));
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

        $response = $this->post(route('update.status', $other), [
            'status' => 'online',
        ]);

        $response->assertStatus(403);
    }

    #[Test]
    public function status_must_be_valid(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('update.status', $user), [
            'status' => 'invalid-status',
        ]);

        $response->assertSessionHasErrors(['status']);
    }
}
