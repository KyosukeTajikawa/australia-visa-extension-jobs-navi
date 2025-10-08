<?php

namespace Tests\Feature;

use App\Models\Farm;
use App\Repositories\FarmRepositoryInterface;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Mockery;
use Mockery\MockInterface;
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
    public function testIndexWithFarms(): void
    {
        //ダミーデータ作成
        $this->instance(
            FarmRepositoryInterface::class,
            Mockery::mock(FarmRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('getAllFarms')
                    ->once()
                    ->andReturn(Farm::factory()->count(2)
                    ->state(new Sequence(
                        ['name' => 'A_farm', 'phone_number' => '029485738'],
                        ['name' => 'B_farm', 'phone_number' => '049482748'],
                    ))
                    ->make());
            })
        );

        $response = $this->get('/home');

        $response->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Home')
                    ->has('farms', 2)
                    ->has(
                        'farms.0',
                        fn(Assert $page) => $page
                            ->where('name', 'A_farm')
                            ->where('phone_number', '029485738')
                            ->etc()
                    )
                    ->has(
                        'farms.1',
                        fn(Assert $page) => $page
                            ->where('name', 'B_farm')
                            ->where('phone_number', '049482748')
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
