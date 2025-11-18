<?php

namespace Tests\Feature\Admin;

use App\Models\Farm;
use App\Models\Review;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AdminDashboardControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * AdminDashboardControllerの確認テスト
     * 5つのプロップスが渡っているか
     */
    public function testAdminDashboardController(): void
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

        $state1 = State::factory()->create(['name' => 'NSW']);

        $farms = Farm::factory()->for($firstUser, 'user')->count(6)->sequence(
            ['name' => 'Farm1', 'state_id' => $state1->id],
            ['name' => 'Farm2', 'state_id' => $state1->id],
            ['name' => 'Farm3', 'state_id' => $state1->id],
            ['name' => 'Farm4', 'state_id' => $state1->id],
            ['name' => 'Farm5', 'state_id' => $state1->id],
            ['name' => 'Farm6', 'state_id' => $state1->id],
        )->create();

        $farmForReviews = $farms->first();

        Review::factory()
            ->count(6)
            ->for($farmForReviews, 'farm')
            ->for($firstUser, 'reviewUser')
            ->create();

        $this->assertDatabaseCount('users', 6);
        $this->assertDatabaseCount('farms', 6);
        $this->assertDatabaseCount('reviews', 6);

        $response = $this->actingAs($firstUser)->get('/admin/dashboard');

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Admin/Dashboard')
                ->where('farmCount', 6)
                ->where('reviewCount', 6)
                ->where('userCount', 6)
                ->has('latestFarms', 5)
                ->where('latestFarms.0.name', 'Farm1')
                ->where('latestFarms.1.name', 'Farm2')
                ->where('latestFarms.2.name', 'Farm3')
                ->has('latestReviews', 5)
        );
    }

    /**
     * 管理者権限ないものを弾くか
     */
    public function testNoAuthenticationUserTryAccessButFail(): void
    {
        $user = User::factory()->create(['is_admin' => 0]);
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');

        $response->assertStatus(403);
        $response->assertSee('このページにアクセスする権限がありません。');
    }
}
