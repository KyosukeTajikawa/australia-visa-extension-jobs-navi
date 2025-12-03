<?php

namespace Tests\Feature\FarmController;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EditTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Createの確認
     * 州・作物情報がCreateに渡っているか確認
     */
    public function testEdit(): void
    {
        $user = User::factory()->create();

        $farm = Farm::factory()->create();

        State::factory()->sequence(['id' => 100], ['id' => 101], ['id' => 102])->count(3)->create();

        Crop::factory()->sequence(['id' => 200], ['id' => 201], ['id' => 202])->count(3)->create();

        $response = $this->actingAs($user)->get("/farm/{$farm->id}/edit");

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Farm/Edit')
                ->has('states', 4)
                ->where('states.1.id', 100)
                ->where('states.2.id', 101)
                ->where('states.3.id', 102)
                ->has('crops', 3)
                ->where('crops.0.id', 200)
                ->where('crops.1.id', 201)
                ->where('crops.2.id', 202)
        );
    }

    /**
     * 未ログイン者をloginにredirectするか
     */
    public function testGuestTryAccessDetailButFail(): void
    {
        $response = $this->get('/farm/Edit');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
