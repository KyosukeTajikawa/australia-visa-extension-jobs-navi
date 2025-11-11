<?php

namespace Tests\Feature\RegisteredUserController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EditTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Editの確認
     */
    public function testEdit(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/edit');

        $response->assertOk();

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Auth/Edit')
                ->where('user.id', $user->id)
                ->where('user.nickname', $user->nickname)
        );
    }

    /**
     * 未ログイン者をloginにredirectするか
     */
    public function testGuestTryAccessDetailButFail(): void
    {
        $response = $this->get('/edit');

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
