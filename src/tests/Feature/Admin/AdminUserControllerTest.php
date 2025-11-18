<?php

namespace Tests\Feature\Admin;

use App\Models\Farm;
use App\Models\Review;
use App\Models\State;
use App\Models\User;
use App\Models\UserImage;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * indexのテスト
     */
    public function testIndex(): void
    {
        $users = User::factory()->count(6)->sequence(
            ['nickname' => 'name1', 'email' => 'email1@email', 'is_admin' => 1],
            ['nickname' => 'name2', 'email' => 'email2@email'],
            ['nickname' => 'name3', 'email' => 'email3@email'],
            ['nickname' => 'name4', 'email' => 'email4@email'],
            ['nickname' => 'name5', 'email' => 'email5@email'],
            ['nickname' => 'name6', 'email' => 'email6@email'],
        )->create();
        $firstUser = $users->first();

        $state = State::factory()->create(['name' => 'NSW']);

        $farms = Farm::factory()->for($firstUser, 'user')->create(['name' => 'Farm1', 'state_id' => $state->id],);

        Review::factory()
            ->for($farms, 'farm')
            ->for($firstUser, 'reviewUser')
            ->create();

        $response = $this->actingAs($firstUser)->get('/admin/user');

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Admin/User')
                ->has('users', 6)
                ->has('users.0.farms', 1)
                ->has('users.0.user_reviews', 1)
        );
    }

    /**
     * detailのテスト
     */
    public function testDetail(): void
    {
        $users = User::factory()->count(6)->sequence(
            ['nickname' => 'name1', 'email' => 'email1@email', 'is_admin' => 1],
            ['nickname' => 'name2', 'email' => 'email2@email'],
            ['nickname' => 'name3', 'email' => 'email3@email'],
            ['nickname' => 'name4', 'email' => 'email4@email'],
            ['nickname' => 'name5', 'email' => 'email5@email'],
            ['nickname' => 'name6', 'email' => 'email6@email'],
        )->create();
        $firstUser = $users->first();

        $state = State::factory()->create(['name' => 'NSW']);

        $farms = Farm::factory()->for($firstUser, 'user')->create(['name' => 'Farm1', 'state_id' => $state->id],);

        Review::factory()
            ->for($farms, 'farm')
            ->for($firstUser, 'reviewUser')
            ->create();

        UserImage::create(['user_id' => $firstUser->id, 'url' => 'url', 'path' => 'path']);

        $response = $this->actingAs($firstUser)->get("/admin/user/{$firstUser->id}");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Admin/Detail')
                ->where('user.nickname', 'name1')
                ->has('user.image')
                ->has('user.farms')
                ->has('user.user_reviews')
                ->has('user.user_reviews.0.farm')
        );
    }

    /**
     * 管理者権限ないものを弾くか
     */
    public function testNoAuthenticationUserTryAccessButFailIndex(): void
    {
        $user = User::factory()->create(['is_admin' => 0]);
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->actingAs($user)->get('/admin/user');

        $response->assertStatus(403);
        $response->assertSee('このページにアクセスする権限がありません。');
    }

    /**
     * 管理者権限ないものを弾くか
     */
    public function testNoAuthenticationUserTryAccessButFailDetail(): void
    {
        $user = User::factory()->create(['is_admin' => 0]);
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->actingAs($user)->get("/admin/user/{$user->id}");

        $response->assertStatus(403);
        $response->assertSee('このページにアクセスする権限がありません。');
    }
}
