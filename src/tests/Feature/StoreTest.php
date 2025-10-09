<?php

namespace Tests\Feature;

use App\Http\Requests\Farms\FarmStoreRequest;
use App\Models\Farm;
<<<<<<< HEAD
use App\Models\FarmImages;
=======
>>>>>>> 9f3e378 (StoreTest作成)
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
<<<<<<< HEAD
use Ramsey\Uuid\Uuid;
use Tests\TestCase;
use Illuminate\Support\Str;
=======
use Tests\TestCase;
>>>>>>> 9f3e378 (StoreTest作成)

class StoreTest extends TestCase
{
    use RefreshDatabase;

<<<<<<< HEAD
    /**
     * storeの処理の確認テスト
     * ルート：作成したルートをたどるか
     * 画像以外：Farmテーブルに保存されるか
     * 画像：S3に期待した名前で保存されるか
     * s3とimagesテーブルの名前が同じか確認
     */
    public function testStoreWithFileSuccess(): void
    {
        //fakeデータの作成
        $user = User::factory()->create();
        $State = State::factory()->create();

        //fakeストレージ作成
        Storage::fake('s3');

        //固定値作成、Strを呼び出す際は$uuidを使ってねと設定
        $uuid = Uuid::fromString('00000-00000-00000');
        Str::createUuidsUsing(fn() => $uuid);

        //ユーザー登録のと同じ形を再現
=======
    public function testStore()
    {
        $user = User::factory()->create();
        $State = State::factory()->create();

        Storage::fake('s3');

>>>>>>> 9f3e378 (StoreTest作成)
        $post = [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
            'street_address' => '2-4-5',
<<<<<<< HEAD
            'suburb' => 'PlainLand',
            'state_id' => $State->id,
            'postcode' => '4000',
            'description' => 'such a good farm',
            'files' => [UploadedFile::fake()->image('avatar.jpg')]
        ];

        //ユーザーが$postをしたことを再現
=======
            'suburb' => 'plainland',
            'state_id' => $State->id,
            'postcode' => '4000',
            'description' => 'such a good farm',
            'files' => UploadedFile::fake()->image('avatar.jpg')
        ];

>>>>>>> 9f3e378 (StoreTest作成)
        $response = $this->actingAs($user)->post(
            route('farm.store'),
            $post
        );

<<<<<<< HEAD
        //302リダイレクトができることを想定
        $response->assertStatus(302);
        //ここまででエラーがないことを想定
        $response->assertSessionHasNoErrors();
        //findorfailでidを取得できないのでfirstorfailにてlimit=1のように登録された$postを取得
        $farm = Farm::firstOrFail();

        //Farm_images_tableから画像を取得
        $farmImages =FarmImages::firstOrFail();

        //本番と同じディレクトリにする。
        //そこにいファイルを保存(postしているため、storeにてputFileAs)がされている
        $path = "farms/{$farm->id}/{$uuid}.jpg";

        //以下にファイルがある事を確認
        Storage::disk('s3')->assertExists($path);

        //Farm_images_tableのurlとS3への登録名が同じか確認
        $this->assertSame($farmImages->url, "{uuid}.jpg");

        //データベースに画像以外が保存されているか確認
        $this->assertDatabaseHas('farms', [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
        ]);

        //リダイレクトされるか確認
        $response->assertRedirect('(farm.detail', ['id' => $farm['id']]);
        //Uuid::fromStringをリセット
        Str::createUuidsNormally();
    }

    /**
     * storeのバリデーション確認
     * 正しい情報の登録をエラーなしで通るか
     */
    public function testStoreValidateSuccess(): void
    {
        $State = State::factory()->create();

        //ユーザー登録のと同じ形を再現
        $data = [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
            'street_address' => '2-4-5',
            'suburb' => 'PlainLand',
            'state_id' => $State->id,
            'postcode' => '4000',
            'description' => 'such a good farm',
        ];

        $rules = (new FarmStoreRequest())->rule();

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

        //ユーザー登録のと同じ形を再現
        $data = [
            'name' => '',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
            'street_address' => '2-4-5',
            'suburb' => 'PlainLand',
            'state_id' => $State->id,
            'postcode' => '40004',
            'description' => 'such a good farm',
        ];

        $rules = (new FarmStoreRequest())->rule();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
        $validator->assertValid('phone_number', 'email', 'street_address', 'suburb', 'state_id', 'description');
        $validator->assertInvalid('name', 'postcode');
    }
=======
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $farm = \App\Models\Farm::first();
        Storage::disk('s3')->assertExists("farms/{$farm->id}");
    }




>>>>>>> 9f3e378 (StoreTest作成)






















    /**
     * A basic feature test example.
     */
    // #[DataProvider('dataProvider')]
    // public function testValidation(array $item, array $data, bool $expect): void
    // {
    //     $dataList = array_merge($item, $data);

    //     $request = new FarmStoreRequest();

    //     $rules = $request->rules();

    //     $validator = Validator::make($dataList, $rules);

    //     $result = $validator->passes();

    //     $this->assertEquals($expect, $result);
    // }

    // public static function dataProvider(): array
    // {
    //     return [
    //         '必須項目エラー' => [
    //             [
    //                 'name' => null,
    //                 'street_address' => null,
    //                 'suburb' => null,
    //                 'postcode' => null
    //             ],
    //             [],
    //             false
    //         ],
    //     ];
    // }
}
