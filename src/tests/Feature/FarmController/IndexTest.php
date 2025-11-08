<?php

namespace Tests\Feature\FarmController;

use App\Models\Farm;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class IndexTest extends TestCase
{

    use RefreshDatabase;

    /**
     * indexの確認
     * ファームがHomeに送られているか
     * 画像も一緒に送られ、かつ、1枚しか送られてないか
     */
    public function testIndexFarmsWithImage(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        $farms = Farm::factory()
            ->count(2)
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $farms[0]->images()->create(['url' => 'test1.jpeg']);
        $farms[1]->images()->create(['url' => 'test2.jpeg']);

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
                        //imagesが1枚しかない。2枚目以降存在する場合はエラーになる。
                        ->has('images', 1)
                        ->where('images.0.url', 'test1.jpeg')
                        ->etc()
                )
        );
    }

    /**
     * indexの確認
     * プロップス（farmデータ）が空でもエラーにならないか
     */
    public function testEmptyFarmsWhenNoneExist(): void
    {
        $this->get('/home')
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home')
                    ->has('farms', 0)
            );
    }
}
