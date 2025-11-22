<?php

namespace Tests\Feature\RegisteredUserController;

use App\Models\User;
use App\Models\UserImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Indexの確認
     * ユーザー・画像情報がprofileに渡っているか確認
     */
    public function testIndex(): void
    {
        $user = User::factory()->create();

        $ImageData = [
            'user_id' => $user->id,
            'url' => 'user/1/sample1.jpg',
            'path' => 'sample1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $userImage = UserImage::create($ImageData);

        $response = $this->actingAs($user)->get('/profile');

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Auth/Profile')
                ->where('user.id', $user->id)
                ->where('user.nickname', $user->nickname)
                ->where('user_image.user_id', $user->id)
                ->where('user_image.url', $userImage->url)
                ->where('user_image.path', $userImage->path)
        );
    }

    /**
     * 未ログイン者をloginにredirectするか
     */
    public function testGuestTryAccessDetailButFail(): void
    {
        $response = $this->get('/profile');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
