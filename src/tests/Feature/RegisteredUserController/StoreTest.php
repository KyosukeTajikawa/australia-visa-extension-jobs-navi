<?php

namespace Tests\Feature\RegisteredUserController;

use App\Http\Requests\Auth\UserStoreRequest;
use App\Models\User;
use App\Models\UserImage;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class StoreTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Storeの確認
     */
    public function testStore(): void
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

        $response->assertRedirect(route('home'));
    }

    /**
     * storeのバリデーション確認
     * 正しい情報の登録をエラーなしで通るか
     */
    public function testStoreValidateSuccess(): void
    {
        $data = [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 1,
            'birthday' => '2000-10-10',
        ];

        $rules = (new UserStoreRequest())->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    /**
     * storeのバリデーション確認
     * 誤った情報の登録をエラーが出るか
     */
    public function testStoreValidateFail(): void
    {
        $data = [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 3,
            'birthday' => '2000-10-10',
        ];

        $rules = (new UserStoreRequest())->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }
}
