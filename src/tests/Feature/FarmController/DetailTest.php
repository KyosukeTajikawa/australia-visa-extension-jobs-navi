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
     * Httpリクエスト(200)が返り、リレーションがない場合の確認
     */
    public function testDetailReceiveFarmPropsNotComeWithReviews(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->get(route('farm.detail', ['id' => $farm->id]));
        $response->assertStatus(200);

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
                            ->has('state', fn(Assert $s) => $s
                                ->hasAll(['id', 'name'])
                                ->etc())
                            ->has('reviews', 0)
                            ->etc()
                    )
            );
    }

    /**
     * フロント(Detail)の確認
     * Httpリクエスト(200)が返り、リレーションがある時の場合の確認
     */
    public function testDetailReceiveFarmPropsComeWithReviewsState(): void
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
                            ->has('state', fn(Assert $s) => $s->hasAll(['id', 'name'])->etc())
                            ->has('reviews', 2)
                            ->has('reviews.0', fn(Assert $r) => $r->hasAll(['id', 'work_position', 'comment'])->etc())
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
