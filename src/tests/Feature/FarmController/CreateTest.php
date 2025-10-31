<?php

namespace Tests\Feature\FarmController;

use App\Models\Crop;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CreateTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Createの確認
     * 州・作物情報がCreateに渡っているか確認
     */
    public function testCreateWithStatesAndCrops(): void
    {
        $user = User::factory()->create();

        State::factory()->sequence(['id' => 10], ['id' => 11], ['id' => 12])->count(3)->create();

        Crop::factory()->sequence(['id' => 20], ['id' => 21], ['id' => 22])->count(3)->create();

        $response = $this->actingAs($user)->get('/farm/create');

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Farm/Create')
                ->has('states', 3)
                ->where('states.0.id', 10)
                ->where('states.1.id', 11)
                ->where('states.2.id', 12)
                ->has('crops', 3)
                ->where('crops.0.id', 20)
                ->where('crops.1.id', 21)
                ->where('crops.2.id', 22)
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
