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

        $response = $this->get(route('users.edit', $user));

        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user', $user);
    }

    #[Test]
    public function non_admin_cannot_view_edit_user_form(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('users.edit', $otherUser));

        $response->assertStatus(403);
    }
}
