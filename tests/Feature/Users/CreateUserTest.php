<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    #[Test]
    public function guest_cannot_access_create_user_form(): void
    {
        $this->get(route('users.create'))->assertRedirect(route('login'));
    }

    #[Test]
    public function regular_user_cannot_access_create_user_form(): void
    {
        $user = User::factory()->create(['role' => 'users']);
        $this->actingAs($user);

        $this->get(route('users.create'))->assertForbidden();
    }

    #[Test]
    public function admin_can_access_create_user_form(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get(route('users.create'))
            ->assertOk()
            ->assertViewIs('users.create');
    }

    #[Test]
    public function admin_can_create_user_with_all_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->post(route('users.store'), [
            'email' => 'new@example.com',
            'password' => 'password',
            'username' => 'New User',
            'job_title' => 'Developer',
            'phone' => '+79001234567',
            'address' => 'Москва, Россия',
            'vk' => 'https://vk.com/test',
            'telegram' => 'https://t.me/test',
            'instagram' => 'https://instagram.com/test',
            'status' => 'online',
            'role' => 'users',
            'image' => $file,
        ]);

        $response->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
        $this->assertDatabaseHas('user_information', ['username' => 'New User']);
        $this->assertDatabaseHas('user_socials', ['vk' => 'https://vk.com/test']);
        $this->assertDatabaseHas('user_media', ['status' => 'online']);

        $user = User::where('email', 'new@example.com')->first();
        $this->assertNotNull($user->media->image);
    }

    #[Test]
    public function user_email_must_be_unique_on_creation(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        User::factory()->create(['email' => 'taken@example.com']);

        $this->post(route('users.store'), [
            'email' => 'taken@example.com',
            'password' => 'password',
            'username' => 'Taken User',
        ])->assertSessionHasErrors(['email']);
    }

    #[Test]
    public function user_can_be_created_without_avatar(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->post(route('users.store'), [
            'email' => 'noavatar@example.com',
            'password' => 'password',
            'username' => 'No Avatar',
        ])->assertRedirect(route('users.index'));

        $user = User::where('email', 'noavatar@example.com')->first();
        $this->assertNull($user->media->image);
    }

    #[Test]
    public function invalid_data_throws_validation_errors(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->post(route('users.store'), [
            'email' => 'invalid-email',
            'password' => '',
        ])->assertSessionHasErrors(['email', 'password']);
    }

    #[Test]
    public function created_user_has_default_role_if_not_set(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->post(route('users.store'), [
            'email' => 'default@example.com',
            'password' => 'password',
            'username' => 'Default Role',
        ])->assertRedirect(route('users.index'));

        $user = User::where('email', 'default@example.com')->first();
        $this->assertEquals('users', $user->role);
    }
}
