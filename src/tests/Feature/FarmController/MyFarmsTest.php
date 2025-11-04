<?php

namespace Tests\Feature\FarmController;

use App\Models\Farm;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class MyFarmsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * myFarmsの確認
     */
    public function testMyFarmsWithImage(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        $farms = Farm::factory()
            ->count(2)
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $farms[0]->images()->create(['url' => 'test1.jpeg', 'path' => 'farm/1/test1.jpeg']);
        $farms[1]->images()->create(['url' => 'test2.jpeg', 'path' => 'farm/2/test2.jpeg']);

        $response = $this->actingAs($user)->get('/farm/myFarms');
        $response->assertStatus(200);
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Farm/MyFarms')
                ->has('farms', 2)
                ->has(
                    'farms.0',
                    fn(Assert $farm) => $farm
                        ->hasAll(['id', 'name'])
                        ->has('images', 1)
                        ->where('images.0.url', 'test1.jpeg')
                        ->etc()
                )
        );
    }


    /**
     * myFarmsの確認
     * プロップス（farmデータ）が空でもエラーにならないか
     */
    public function testEmptyFarmsWhenNoneExist(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/farm/myFarms')
            ->assertInertia(
                fn(Assert $page) => $page
                ->component('Farm/MyFarms')
                    ->has('farms', 0)
            );
    }
}
