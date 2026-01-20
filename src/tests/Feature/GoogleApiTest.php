<?php

namespace Tests\Feature;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleApiTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testGoogleApi(): void
    {
        Http::fake([
            'https://maps.googleapis.com/maps/api/geocode/json*' => Http::response([
                'status' => 'OK',
                'results' => [
                    [
                        'geometry' => [
                            'location' => [
                                'lat' => -27.4705,
                                'lng' => 153.0260,
                            ],
                        ],
                    ],
                ],
            ], 200),
        ]);

        config()->set('services.google_map.key', 'test-key');

        $user = User::factory()->create();
        Crop::factory()->create();
        $state = State::create([
            'name' => 'QLD',
        ]);

        $farm = Farm::factory()->for($user, 'user')->for($state, 'state')->create();

        $farm->update([
            'street_address' => '66 Lake Clarendon Way',
            'suburb'         => 'Lake Clarendon',
            'postcode'       => '4343',
        ]);

        $this->assertNotEmpty($farm->fullAddress());

        $farm->refresh();

        $this->assertDatabaseHas('farms', [
            'street_address' => '66 Lake Clarendon Way',
            'suburb'         => 'Lake Clarendon',
            'postcode'       => '4343',
        ]);

        $this->assertEquals(-27.4705, $farm->latitude, '', 0.000001);
        $this->assertEquals(153.0260, $farm->longitude, '', 0.000001);

        Http::assertSent(function ($request) {
            return str_starts_with($request->url(), 'https://maps.googleapis.com/maps/api/geocode/json')
                && isset($request['address'])
                && isset($request['key']);
        });
    }
}
