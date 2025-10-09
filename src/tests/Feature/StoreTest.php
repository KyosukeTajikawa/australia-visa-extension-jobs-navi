<?php

namespace Tests\Feature;

use App\Http\Requests\Farms\FarmStoreRequest;
use App\Models\Farm;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testStore(): void
    {
        $user = User::factory()->create();
        $State = State::factory()->create();

        Storage::fake('s3');

        $post = [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
            'street_address' => '2-4-5',
            'suburb' => 'PlainLand',
            'state_id' => $State->id,
            'postcode' => '4000',
            'description' => 'such a good farm',
            'files' => UploadedFile::fake()->image('avatar.jpg')
        ];

        $response = $this->actingAs($user)->post(
            route('farm.store'),
            $post
        );

        $response->assertStatus(302);
        $response->assertRedirect('(farm.detail', ['id' => $post['id']]);
        $response->assertSessionHasNoErrors();
        $farm = Farm::first();
        Storage::disk('s3')->assertExists("farms/{$farm->id}");
        Storage::disk('s3')->assertExists($post['files']->hashName());

        $this->assertDatabaseHas('farms', [
            'name' => 'A_farm',
            'phone_number' => '0492845949',
            'email' => 'test@gmail.com',
        ]);
    }


























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
