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
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * updateの処理の確認テスト
     * ルート：作成したルートをたどるか
     * テーブル：1度目の登録内容を更新するか
     * 画像：S3に保存されているデータを置き換えるか
     * s3とimagesテーブルのURLカラムと名前が同じか確認
     */
    public function testStoreWithFileSuccess(): void
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
            'files'          => [UploadedFile::fake()->image('avatar.jpg')],
            'crop_ids'       => $crops->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($user)->post(
            route('farm.store'),
            $post
        );

        $farmFirst = Farm::firstOrFail();
        $farmImageFirst = FarmImages::firstOrFail();

        $firstPath = "farms/{$farmFirst->id}/avatar.jpg";

        Storage::disk('s3')->assertExists($firstPath);

        $expectedUrl = Storage::disk('s3')->url($firstPath);

        $this->assertSame($expectedUrl, $farmImageFirst->url);

        $response->assertRedirect(route('farm.detail', ['id' => $farmFirst->id]));

        $this->assertSame($post['name'], $farmFirst->name);

        $this->assertDatabaseHas('farm_images', [
            'url' => $farmFirst->images->first()->url,
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
            'files'          => [UploadedFile::fake()->image('dummy.png')],
            'crop_ids'       => $crops->pluck('id')->toArray(),
        ];

        $response = $this->actingAs($user)->put(
            route('farm.update', ['id' => $farmFirst->id]),
        $secondPost
        );

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $farmSecond = Farm::firstOrFail();
        $farmImagesSecond = FarmImages::firstOrFail();

        $this->assertSame($secondPost['name'], $farmSecond->name);

        $secondPath = "farms/{$farmSecond->id}/dummy.png";

        Storage::disk('s3')->assertMissing($firstPath);
        Storage::disk('s3')->assertExists($secondPath);

        $SecondExpectedUrl = Storage::disk('s3')->url($secondPath);
        $this->assertSame($SecondExpectedUrl, $farmImagesSecond->url);

        $this->assertDatabaseMissing('farm_images', [
            'url' => $farmFirst->images->first()->url,
        ]);

        $this->assertDatabaseHas('farm_images', [
            'url' => $farmSecond->images->first()->url,
        ]);

        $response->assertRedirect(route('farm.detail', ['id' => $farmSecond->id]));
    }
}
