<?php

namespace Tests\Feature;

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
     * モックから返されたダミーデータが、ちゃんと Inertia 経由でフロント(props)に渡っているか
     * モックにてFarmRepositoryInterfaceを利用して事前にダミーデータを作成
     * $this->get('/home')によりイベント発火(web.phpを通り、FarController/indexに渡ってFarmRepositoryInterfaceからダミーデータを作成)
     * inertiaPropsのレスポンスで返された値を確認してHomeにprops（ダミーデータ）が渡っているかをテストすることができる。
     * fn(Assert $page) => $pageと毎回記述する理由は、inertiaが返したpropsの一部をテストが受け取っているから。
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
                        ->has(
                            'images.0',
                            fn(Assert $i) => $i
                                ->where('url', 'test1.jpeg')
                                ->etc()
                        )
                        ->etc()
                )
        );
    }

    /**
     * indexメソッドの確認
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
