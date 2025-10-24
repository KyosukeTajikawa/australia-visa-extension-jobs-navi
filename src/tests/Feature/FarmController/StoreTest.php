<?php

namespace Tests\Feature\FarmController;

use App\Http\Requests\Farms\FarmStoreRequest;
use App\Models\Crop;
use App\Models\Farm;
use App\Models\FarmImages;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Illuminate\Support\Str;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * storeの処理の確認テスト
     * ルート：作成したルートをたどるか
     * 画像以外：Farmテーブルに保存されるか
     * 画像：S3に期待した名前で保存されるか
     * s3とimagesテーブルのURLカラムと名前が同じか確認
     */
    public function testStoreWithFileSuccess(): void
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);

        //fakeデータの作成
        $user = User::factory()->create();
        $State = State::factory()->create();
        $crops = Crop::factory()->count(3)->create();

        //fakeストレージ作成
        Storage::fake('s3');

        //ユーザー登録のと同じ形を再現
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

        //ユーザーが$postをしたことを再現
        $response = $this->actingAs($user)->post(
            route('farm.store'),
            $post
        );

        //302リダイレクトができることを想定
        $response->assertStatus(302);
        //ここまででエラーがないことを想定
        $response->assertSessionHasNoErrors();
        //findorfailでidを取得できないのでfirstorfailにてlimit=1のように登録された$postを取得
        $farm = Farm::firstOrFail();

        //Farm_images_tableから画像を取得
        $farmImages = FarmImages::firstOrFail();

        //本番と同じディレクトリにする。
        //そこにいファイルを保存(postしているため、storeにてputFileAs)がされている
        $path = "farms/{$farm->id}/avatar.jpg";

        //以下にファイルがある事を確認
        Storage::disk('s3')->assertExists($path);

        //S3に保存されたファイルのURLを取得（DBと比較用）
        $expectedUrl = Storage::disk('s3')->url($path);

        //Farm_images_tableのurlとS3への登録名が同じか確認
        $this->assertSame($expectedUrl, $farmImages->url);

        //データベースに画像以外が保存されているか確認
        $this->assertDatabaseHas('farms', [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
        ]);

        //リダイレクトされるか確認
        $response->assertRedirect(route('farm.detail', ['id' => $farm->id]));
        //Uuid::fromStringをリセット
        Str::createUuidsNormally();
    }

    /**
     * storeのバリデーション確認
     * 正しい情報の登録をエラーなしで通るか
     */
    public function testStoreValidateSuccess(): void
    {
        $state = State::factory()->create();
        $user = User::factory()->create();
        $crops = Crop::factory()->count(3)->create();

        //ユーザー登録のと同じ形を再現
        $data = [
            'name'            => 'A_farm',
            'phone_number'    => '0492845949',
            'email'           => 'test@gmail.com',
            'street_address'  => '2-4-5',
            'suburb'          => 'PlainLand',
            'state_id'        => $state->id,
            'postcode'        => '4000',
            'description'     => 'such a good farm',
            'created_user_id' => $user->id,
            'crop_ids'        => $crops->pluck('id')->toArray(),
        ];

        $rules = (new FarmStoreRequest())->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    /**
     * storeのバリデーション確認
     * 誤った情報の登録をエラーが出るか
     */
    public function testStoreValidateFail(): void
    {
        $State = State::factory()->create();
        $user = User::factory()->create();

        //ユーザー登録のと同じ形を再現
        $data = [
            'name'            => '',
            'phone_number'    => '0492845949',
            'email'           => 'test@gmail.com',
            'street_address'  => '2-4-5',
            'suburb'          => 'PlainLand',
            'state_id'        => $State->id,
            'postcode'        => '40004',
            'description'     => 'such a good farm',
            'created_user_id' => $user->id,
        ];

        $rules = (new FarmStoreRequest())->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }
}
