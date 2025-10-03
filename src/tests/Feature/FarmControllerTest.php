<?php

namespace Tests\Feature;

use App\Models\Farm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FarmControllerTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $farm = Farm::factory()->create([
            'name' => 'testFarm',
            'description' => 'Great Farm',
        ]);

        $response = $this->get('/home');

        $response->assertInertia(fn ($page) => $page
        ->cpmponent('Home')
        ->has('farm', 1)
        ->where('farms.0.name', 'testFarm')
        );
    }
}
