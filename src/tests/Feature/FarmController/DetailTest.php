<?php

namespace Tests\Feature;

use App\Models\Farm;
use App\Models\Review;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DetailTest extends TestCase
{

    use RefreshDatabase;

    /**
     * フロント(Detail)の確認
     * factoryにてUserとStateを作成。それをforでFarmのbelongsToとする
     * Httpリクエスト(200)が返り、リレーションがない場合の確認
     * assertInertiaとしてdetailのreturn Inertia::renderと同じ動きをし１つずつ届いているか確認
     */
    public function testDetailFarmNotComeWithReviews(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->get(route('farm.detail', ['id' => $farm->id]));

        $response->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Farm/Detail')
                    ->has('farm')
                    ->has(
                        'farm',
                        fn(Assert $f) => $f
                            ->where('id', $farm->id)
                            ->where('name', $farm->name)
                            ->has(
                                'state',
                                fn(Assert $s) => $s
                                    ->where('id', $farm->state->id)
                                    ->where('name', $farm->state->name)
                                    ->etc()
                            )
                            ->has('reviews', 0)
                            ->etc()
                    )
            );
    }

    /**
     * フロント(Detail)の確認
     * hasにてhasManyとしてFarmのリレーションとする
     * state,reviews[0],[1]全てをテスト
     */
    public function testDetailReceiveFarmComeWithReviewsAndState(): void
    {
        $user  = User::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->has(Review::factory()->count(2), 'reviews')
            ->create();

        $response = $this->get(route('farm.detail', ['id' => $farm->id]));

        $response->assertOk()
            ->assertInertia(
                fn(Assert $page) => $page
                    ->component('Farm/Detail')
                    ->has('farm')
                    ->has(
                        'farm',
                        fn(Assert $f) => $f
                            ->where('id', $farm->id)
                            ->has(
                                'state',
                                fn(Assert $s) => $s
                                    ->where('id', $farm->state->id)
                                    ->where('name', $farm->state->name)
                                    ->etc()
                            )
                            ->has('reviews', 2)
                            ->has(
                                'reviews.0',
                                fn(Assert $r) => $r
                                    ->where('id', $farm->reviews[0]->id)
                                    ->where('work_position', $farm->reviews[0]->work_position)
                                    ->etc()
                            )
                            ->has(
                                'reviews.1',
                                fn(Assert $r) => $r
                                    ->where('id', $farm->reviews[1]->id)
                                    ->where('work_position', $farm->reviews[1]->work_position)
                                    ->etc()
                            )
                            ->etc()
                    )
            );
    }

    /**
     * フロント(Detail)の確認
     * Httpリクエスト(404)が返るかの確認
     */
    public function testDetailThrowsModelNotFoundException(): void
    {
        $this->get(route('farm.detail', ['id' => 999999]))
            ->assertNotFound();

        $this->withoutExceptionHandling();

        $this->expectException(ModelNotFoundException::class);

        $this->get(route('farm.detail', ['id' => 999999]));
    }
}
