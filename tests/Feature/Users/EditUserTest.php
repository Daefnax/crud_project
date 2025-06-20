<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_view_edit_user_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('edit', ['id' => $user->id]));

        $response->assertStatus(200);
        $response->assertViewIs('edit_user');
        $response->assertViewHas('users', $user);
    }

    #[Test]
    public function non_admin_cannot_view_edit_user_form(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('edit', ['id' => $otherUser->id]));

        $response->assertStatus(403);
    }
}
