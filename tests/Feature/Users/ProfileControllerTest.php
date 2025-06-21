<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_cannot_access_profile_page(): void
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.profile', $user));
        $response->assertRedirect(route('login'));
    }

    #[Test]
    public function user_can_view_own_profile(): void
    {
        $user = User::factory()->hasInformation()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.profile', $user));

        $response->assertOk();
        $response->assertViewHas('user');
        $response->assertSee($user->email);
        $response->assertSeeText($user->information->username ?? '');
    }

    #[Test]
    public function user_can_see_avatar_or_default_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.profile', $user));
        $response->assertSee('avatar-m.png');

        $user->media()->create(['image' => 'avatar.jpg']);
        $response = $this->get(route('users.profile', $user));
        $response->assertSee('uploads/avatar.jpg');
    }

    #[Test]
    public function user_can_see_social_links_if_they_are_set(): void
    {
        $user = User::factory()->create();
        $user->socials()->create([
            'vk' => 'https://vk.com/test',
            'telegram' => 'https://t.me/test',
            'instagram' => 'https://instagram.com/test'
        ]);
        $this->actingAs($user);

        $response = $this->get(route('users.profile', $user));

        $response->assertSee('https://vk.com/test');
        $response->assertSee('https://t.me/test');
        $response->assertSee('https://instagram.com/test');
    }

    #[Test]
    public function user_does_not_see_social_links_when_empty(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.profile', $user));

        $response->assertDontSee('https://vk.com');
        $response->assertDontSee('https://t.me');
        $response->assertDontSee('https://instagram.com');
    }

    #[Test]
    public function user_can_view_another_profile_by_id(): void
    {
        $owner = User::factory()->create();
        $anotherUser = User::factory()->create();
        $this->actingAs($owner);

        $response = $this->get(route('users.profile', $anotherUser));

        $response->assertOk();
        $response->assertViewHas('user', $anotherUser);
    }

    #[Test]
    public function invalid_user_id_returns_404(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('users.profile',['user' => 99999]));
        $response->assertNotFound();
    }
}
