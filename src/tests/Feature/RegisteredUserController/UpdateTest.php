<?php

namespace Tests\Feature\RegisteredUserController;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Updateの確認
     */
    public function testUpdate(): void
    {

        $this->withoutMiddleware(VerifyCsrfToken::class);

        Storage::fake('s3');

        $firstRegister = [
            'file' => UploadedFile::fake()->image('avatar1.jpg'),
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 1,
            'birthday' => '2000-10-10',
        ];

        $this->post(route('register.store'), $firstRegister);

        $this->assertDatabaseHas('users', [
            'nickname' => $firstRegister['nickname'],
        ]);

        $previousUser = User::firstOrFail();

        $firstPath = "users/{$previousUser->id}/avatar1.jpg";

        Storage::disk('s3')->assertExists($firstPath);

        $previousUserImage = UserImage::firstOrFail();

        $this->assertDatabaseHas('user_images', [
            'url' => $previousUserImage->url,
        ]);


        $secondRegister = [
            'file' => UploadedFile::fake()->image('avatar2.jpg'),
            'nickname' => 'User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 2,
            'birthday' => '2000-10-10',
        ];

        $response = $this->actingAs($previousUser)->put('update', $secondRegister);


        $newUser = User::firstOrFail();
        $newUserImage = UserImage::firstOrFail();

        $this->assertSame($secondRegister['nickname'], $newUser->nickname);

        $secondPath = "users/{$newUser->id}/avatar2.jpg";

        Storage::disk('s3')->assertMissing($firstPath);
        Storage::disk('s3')->assertExists($secondPath);

        $SecondExpectedUrl = Storage::disk('s3')->url($secondPath);
        $this->assertSame($SecondExpectedUrl, $newUserImage->url);

        $this->assertDatabaseMissing('user_images', [
            'url' => $previousUserImage->url,
        ]);

        $this->assertDatabaseHas('user_images', [
            'url' => $newUserImage->url,
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHasNoErrors();
    }

    /**
     * updateのバリデーション確認
     * 正しい情報の登録をエラーなしで通るか
     */
    public function testUpdateValidateSuccess(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 1,
            'birthday' => '2000-10-10',
        ];

        $response = $this->put(route('update'), $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors(['nickname', 'email', 'gender']);
    }

    /**
     * updateのバリデーション確認
     * 誤った情報の登録をエラーが出るか
     */
    public function testUpdateValidateFail(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 3,
            'birthday' => '2000-10-10',
        ];

        $response = $this->put(route('update'), $data);

        $response->assertSessionHasErrors(['gender']);
    }
}
