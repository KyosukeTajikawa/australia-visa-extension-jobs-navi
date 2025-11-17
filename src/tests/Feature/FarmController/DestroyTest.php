<?php

namespace Tests\Feature\FarmController;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\FarmImages;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DestroyTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Destroyの確認
     * Destroyで画像が削除されるか
     */
    public function testDestroy(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->create();
        $State = State::factory()->create();
        $crops = Crop::factory()->count(3)->create();

        Storage::fake('s3');

        $post = [
            'name'           => 'A_farm',
            'phone_number'   => '0492845949',
            'email'          => 'test@gmail.com',
            'street_address' => '2-4-5',
            'suburb'         => 'PlainLand',
            'state_id'       => $State->id,
            'postcode'       => '4000',
            'description'    => 'such a good farm',
            'files'          => [UploadedFile::fake()->image('avatar1.jpg')],
            'crop_ids'       => $crops->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($user)->post(
            route('farm.store'),
            $post
        );

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $farm = Farm::firstOrFail();
        FarmImages::firstOrFail();

        $path = "farms/{$farm->id}/avatar1.jpg";

        Storage::disk('s3')->assertExists($path);

        $this->assertDatabaseHas('farms', [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
        ]);

        $this->assertDatabaseHas('farm_images', [
            'farm_id' => $farm->id,
            'path' => "farms/{$farm->id}/avatar1.jpg",
        ]);

        $response = $this->actingAs($user)->delete(
            route('farm.image.destroy', ['id' => $farm->id])
        );

        Storage::disk('s3')->assertMissing($path);

        $this->assertDatabaseMissing('farm_images', [
            'farm_id' => $farm->id,
            'path' => "farms/{$farm->id}/avatar1.jpg",
        ]);
    }
}
