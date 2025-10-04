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

    public function test_home_receive_farm_props(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        Farm::factory()
            ->count(2)
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->get('/home');
        //画面が開くか
        $response->assertStatus(200);
        //viewにDBからのデータが渡っているか。中身が正しいか。
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Home')
                ->has('farms', 2)
                ->has(
                    'farms.0',
                    fn(Assert $farm) => $farm
                        ->hasAll(['id', 'name'])
                        ->etc()
                )
        );
    }

    public function test_home_shows_empty_farms_when_none_exist(): void
    {
        $this->get('/home')
            ->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home')
                    // farmsが空配列として存在していることを確認
                    ->has('farms', 0)
            );
    }
}
