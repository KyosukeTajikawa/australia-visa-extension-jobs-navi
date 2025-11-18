<?php

namespace Tests\Feature\Admin;

use App\Models\Crop;
use App\Models\Farm;
use App\Models\FarmImages;
use App\Models\Review;
use App\Models\ReviewComments;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminFarmControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * editのテスト
     */
    public function testEdit(): void
    {
        $user = User::factory()->create(['is_admin' => 1]);
        $state = State::factory()->create(['name' => 'NSW']);
        $crops = Crop::factory()->sequence(['name' => 'Crop20'], ['name' => 'Crop21'], ['name' => 'Crop22'],)->count(3)->create();
        $farm = Farm::factory()->hasAttached($crops, [], 'crops')->create(['name' => 'Farm1', 'state_id' => $state->id],);
        FarmImages::create(['farm_id' => $farm->id, 'url' => 'url', 'path' => 'path']);

        $response = $this->actingAs($user)->get("/admin/farm/{$farm->id}/edit");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Admin/FarmEdit')
                ->where('farm.name', $farm->name)
                ->has('farm.state')
                ->where('farm.state.name', 'NSW')
                ->has('farm.crops', 3)
                ->has('farm.images')
                ->where('farm.images.0.url', 'url')
                ->has('states', 1)
                ->has('crops', 3)
        );
    }
    /**
     * updateのテスト
     */
    public function testUpdate(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->create(['is_admin' => 1]);
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
            'files'          => [UploadedFile::fake()->image('avatar.jpg')],
            'crop_ids'       => $crops->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($user)->post(
            route('farm.store'),
            $post
        );

        $this->assertDatabaseHas('farms', [
            'name' => 'A_farm',
            'email'          => 'test@gmail.com',
            'street_address' => '2-4-5',
        ]);

        $farm = Farm::firstOrFail();

        foreach ($crops as $crop) {
            $this->assertDatabaseHas('farm_crops', [
                'farm_id' => $farm->id,
                'crop_id' => $crop->id,
            ]);
        }

        $farmImageFirst = FarmImages::firstOrFail();

        $Path = "farms/{$farm->id}/avatar.jpg";

        Storage::disk('s3')->assertExists($Path);

        $expectedUrl = Storage::disk('s3')->url($Path);

        $this->assertSame($expectedUrl, $farmImageFirst->url);

        $response->assertRedirect(route('farm.detail', ['id' => $farm->id]));

        $this->assertSame($post['name'], $farm->name);

        $this->assertDatabaseHas('farm_images', [
            'url' => $farm->images->first()->url,
        ]);

        $secondPost = [
            'name'           => 'B_farm',
            'phone_number'   => '',
            'email'          => 'test@gmail.com',
            'street_address' => '2-4-5',
            'suburb'         => 'PlainLand',
            'state_id'       => $State->id,
            'postcode'       => '4000',
            'description'    => 'such a good farm',
            'files'          => [
                UploadedFile::fake()->image('dummy1.png'),
                UploadedFile::fake()->image('dummy2.png'),
            ],
            'crop_ids'       => $crops->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($user)->put(
            route('admin.farm.update', ['id' => $farm->id]),
            $secondPost
        );

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $farm->refresh();

        $this->assertNotSame('A_farm', $farm->name);
        $this->assertSame($secondPost['name'], $farm->name);

        foreach ($farm->images as $image) {
            Storage::disk('s3')->assertExists($image->path);
        }

        $response->assertRedirect(route('user.detail', [
            'id' => $farm->created_user_id,
        ]));
    }

    /**
     * Destroyの確認
     */
    public function testDestroy(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        $user = User::factory()->create(['is_admin' => 1]);
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
            'files'          => [UploadedFile::fake()->image('avatar.jpg')],
            'crop_ids'       => $crops->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($user)->post(
            route('farm.store'),
            $post
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas('farms', [
            'name' => 'A_farm',
            'email'          => 'test@gmail.com',
            'street_address' => '2-4-5',
        ]);

        $farm = Farm::firstOrFail();

        $this->assertDatabaseHas('farm_images', [
            'path' => "farms/{$farm->id}/avatar.jpg",
        ]);

        $review = Review::factory()->for($farm, 'farm')->create();
        $reviewComment = ReviewComments::create([
            'user_id' => $user->id,
            'review_id' => $review->id,
            'comment' => 'コメント',
        ]);

        $response = $this->actingAs($user)->delete(
            route('admin.farm.destroy', ['id' => $farm->id]));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('farms', [
            'name' => 'A_farm',
            'email'          => 'test@gmail.com',
            'street_address' => '2-4-5',
        ]);

        $this->assertDatabaseMissing('farm_images', [
            'path' => "farms/{$farm->id}/avatar.jpg",
        ]);

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
        ]);

        $this->assertDatabaseMissing('review_comments', [
            'id' => $reviewComment->id,
        ]);

        $this->assertDatabaseMissing('farm_crops', [
            'farm_id' => $farm->id,
        ]);

        $response->assertRedirect(route('user.detail', ['id' => $user->id]));
    }
}
