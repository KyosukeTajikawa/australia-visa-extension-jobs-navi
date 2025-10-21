<?php

namespace Tests\Feature;

use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CreateTest extends TestCase
{

    use RefreshDatabase;

    /**
     * フロント(Create)の確認
     * 州情報がCreateに渡っているか確認
     */
    public function testCreate(): void
    {
        $user = User::factory()->create();

        State::factory()->sequence(['id' => 10], ['id' => 11], ['id' => 12])->count(3)->create();

        $response = $this->actingAs($user)->get('/farm/create');

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Farm/Create')
                ->has('states', 3)
                ->has(
                    'states.0',
                    fn(Assert $s) => $s
                        ->where('id', 10)
                        ->etc()
                )
                ->has(
                    'states.1',
                    fn(Assert $s) => $s
                        ->where('id', 11)
                        ->etc()
                )
                ->has(
                    'states.2',
                    fn(Assert $s) => $s
                        ->where('id', 12)
                        ->etc()
                )
        );
    }

    /**
     * 未ログイン者をloginにredirectするか
     */
    public function testGuestTryAccessDetailButFail(): void
    {
        $response = $this->get('/farm/create');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
