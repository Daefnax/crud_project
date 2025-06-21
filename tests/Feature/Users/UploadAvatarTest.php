<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UploadAvatarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $path = base_path('tests/Fixtures');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $base64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAuMBgUv9enEAAAAASUVORK5CYII=';
        file_put_contents($path . '/avatar.png', base64_decode($base64));
    }


    #[Test]
    public function user_can_upload_own_avatar()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->post(route('upload.avatar', $user), [
            'image' => $file,
        ]);

        $response->assertRedirect(route('users.profile', $user));
        $this->assertDatabaseHas('user_media', ['user_id' => $user->id]);
    }

    #[Test]
    public function user_cannot_upload_for_others(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $this->actingAs($user);
        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->post(route('upload.avatar', $other), [
            'image' => $file,
        ]);

        $response->assertStatus(403);
    }
}
