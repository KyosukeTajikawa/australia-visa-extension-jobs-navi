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

    public function test_Detail_receive_farm_props_not_come_with_reviews(): void
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

    public function test_Detail_receive_farm_props_come_with_reviews_state(): void
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

    public function test_detail_throws_model_not_found_exception(): void
    {
        $this->get(route('farm.detail', ['id' => 999999]))
            ->assertNotFound();

        $this->withoutExceptionHandling();

        $this->expectException(ModelNotFoundException::class);

        $this->get(route('farm.detail', ['id' => 999999]));
    }
}
