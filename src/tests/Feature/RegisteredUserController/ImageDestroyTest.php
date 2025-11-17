<?php

namespace Tests\Feature\RegisteredUserController;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageDestroyTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Storeの確認
     */
    public function testImageDestroy(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('s3');

        $post = [
            'file' => UploadedFile::fake()->image('avatar.jpg'),
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 1,
            'birthday' => '2000-10-10',
        ];

        $response = $this->post(
            route('register.store'),
            $post
        );

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $user = User::firstOrFail();

        $userImage = UserImage::firstOrFail();

        $path = "users/{$user->id}/avatar.jpg";

        Storage::disk('s3')->assertExists($path);

        $expectedUrl = Storage::disk('s3')->url($path);

        $this->assertSame($expectedUrl, $userImage->url);

        $this->assertDatabaseHas('users', [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'gender' => 1,
        ]);

        $response = $this->actingAs($user)->delete(
            route('user.image.destroy', ['id' => $user->id])
        );

        Storage::disk('s3')->assertMissing($path);

        $this->assertDatabaseMissing('user_images', [
            'user_id' => $user->id,
            'path' => "users/{$user->id}/avatar1.jpg",
        ]);


    }



}
