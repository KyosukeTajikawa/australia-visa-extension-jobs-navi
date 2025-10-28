<?php

namespace Tests\Feature\ReviewController;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CreateTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCreate(): void
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->sequence(['id' => 2, 'name' => 'AFarm'])->create();

        $response = $this->actingAs($user)->get(route('review.create', ['id' => $farm->id]));

        $response->assertInertia(
            fn(Assert $page) => $page
            ->component('Review/Create')
            ->where('farm.id', 2)
            ->where('farm.name', 'AFarm')
        );
    }

    /**
     * フロント(Create)の確認
     * Httpリクエスト(404)が返るかの確認
     */
    public function testCreateThrowsModelNotFoundException(): void
    {
        $user  = User::factory()->create();

        $this->actingAs($user)->get(route('review.create', ['id' => 999999]))->assertNotFound();

        $this->withoutExceptionHandling();

        $this->expectException(ModelNotFoundException::class);

        $this->get(route('farm.detail', ['id' => 999999]));
    }

    /**
     * 未ログイン者をloginにredirectするか
     */
    public function testGuestTryAccessDetailButFail(): void
    {
        $farm = Farm::factory()->sequence(['id' => 2])->create();

        $response = $this->get(route('farm.detail', ['id' => $farm->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
