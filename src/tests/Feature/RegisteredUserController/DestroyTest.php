<?php

namespace Tests\Feature\RegisteredUserController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Destroyの確認
     */
    public function testDestroy(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/destroy');

        $response->assertRedirect();

        $this->assertSoftDeleted('users', ['id' => $user->id]);

        $this->assertGuest();
    }

}
