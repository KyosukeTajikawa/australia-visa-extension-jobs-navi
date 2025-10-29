<?php

namespace Tests\Feature\Auth;

use App\Http\Requests\Reviews\ReviewStoreRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Createの確認
     * HTTPレスポンスの確認
     */
    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * storeの確認
     * 登録後のログイン状態とリダイレクト
     */
    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'gender' => 1,
            'birthday' => '2000-10-10',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
    }

    /**
     * storeのバリデーション確認
     * 誤ったユーザー登録に対するエラー
     * birthdayの桁数がNG
     */
    public function testStoreValidateFail(): void
    {

        $data = [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'gender' => 1,
            'birthday' => '20001-10-101',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $rules = (new ReviewStoreRequest())->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }
}
