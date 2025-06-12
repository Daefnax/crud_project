<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_update_user_info(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $this->actingAs($admin);

        $response = $this->post(route('update', $user->id), [
            'username' => 'Updated Name',
            'job_title' => 'Manager',
            'phone' => '1234567890',
            'address' => 'City Center',
        ]);

        $response->assertRedirect(route('users'));

        $this->assertDatabaseHas('user_information', [
            'user_id' => $user->id,
            'username' => 'Updated Name',
        ]);
    }

    #[Test]
    public function unauthorized_user_is_redirected(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('update', $user->id), [
            'username' => 'Hack Attempt',
        ]);

        $response->assertRedirect(route('login'));
    }
}
