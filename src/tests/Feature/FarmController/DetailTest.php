<?php

namespace Tests\Feature;

use App\Models\Crop;
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
    public function testDetailFarmNotComeWithRelation(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->actingAs($user)->get(route('farm.detail', ['id' => $farm->id]));

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
     * 登録したstate,reviews,images,crops全てが期待した値かをInertiaのJsonResponseを用いてテスト
     */
    public function testDetailReceiveFarmComeWithRelation(): void
    {
        $user  = User::factory()->create();
        $state = State::factory()->create();
        $crops = Crop::factory()->count(3)->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->has(Review::factory()->count(2), 'reviews')
            ->create();

            $farm->images()->create(['url' => 'test1.jpeg']);
            $farm->images()->create(['url' => 'test2.jpeg']);

            $farm->crops()->sync($crops->pluck('id')->toArray());

        $response = $this->actingAs($user)->get(route('farm.detail', ['id' => $farm->id]));

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
                            ->has('images', 2)
                            ->has(
                                'images.0',
                                fn(Assert $i) => $i
                                    ->where('url', 'test1.jpeg')
                                    ->etc()
                            )
                            ->has(
                                'images.1',
                                fn(Assert $i) => $i
                                    ->where('url', 'test2.jpeg')
                                    ->etc()
                            )
                            ->has('crops', 3)
                            ->where('crops.0.id', $crops[0]->id)
                            ->where('crops.1.id', $crops[1]->id)
                            ->where('crops.2.id', $crops[2]->id)
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
        $user  = User::factory()->create();

        $this->actingAs($user)->get(route('farm.detail', ['id' => 999999]))
            ->assertNotFound();

        $this->withoutExceptionHandling();

        $this->expectException(ModelNotFoundException::class);

        $this->get(route('farm.detail', ['id' => 999999]));
    }

    /**
     * 未ログイン者をloginにredirectするか
     */
    public function testGuestTryAccessDetailButFail(): void
    {
        $user = User::factory()->create();
        $state = State::factory()->create();

        $farm = Farm::factory()
            ->for($user, 'user')
            ->for($state, 'state')
            ->create();

        $response = $this->get(route('farm.detail', ['id' => $farm->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
