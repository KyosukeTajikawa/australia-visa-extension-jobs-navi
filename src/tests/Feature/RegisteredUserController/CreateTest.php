<?php

namespace Tests\Feature\RegisteredUserController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Createの確認
     */
    public function testCreateWithStatesAndCrops(): void
    {

        $response = $this->get('/register');

        $response->assertOk();
    }

}
