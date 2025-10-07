<?php

namespace Tests\Feature;

use App\Models\Farm;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomeTest extends TestCase
{

    use RefreshDatabase;

    /**
     * フロント(Home)の確認
     * プロップスが届いており、その配列が期待しているプロップスであるかの確認
     * assertOk()でHTTP200のレスポンスを受け取っているか
     * assertInertia(fn(Assert $page) => $pageにてHome.tsxにて$pageというレスポンスを取得しており->component('Home')->has('farms', 2)はreturn Inertia::render('Home', ['farms' => $farms,の第一引数と第二引数が受け取れているかの確認となっている。
     * さらにその$farmはwhereNot('id', null)にてデータが入っていることを証明している
     */
    public function testHomeReceiveFarmProps(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        Farm::factory()
            ->count(2)
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->get('/home');

        $response->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home')
                    ->has('farms', 2)
                    ->has(
                        'farms.0',
                        fn(Assert $farm) => $farm
                            ->whereNot('id', null)
                            ->whereNot('name', null)
                            ->etc()
                    )
            );
    }

    /**
     * フロント(Home)の確認
     * プロップスが空配列でも届くか
     */
    public function testHomeShowsEmptyFarmsWhenNoneExist(): void
    {
        $this->get('/home')
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home')
                    ->has('farms', 0)
            );
    }
}
