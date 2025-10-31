<?php

namespace Tests\Feature\ReviewController;

use App\Http\Requests\Reviews\ReviewStoreRequest;
use App\Models\Farm;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * storeの処理の確認テスト
     * ルート：作成したルートをたどるか
     * レビュー：reviewテーブルに保存されるか
     */
    public function testStore(): void
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->create();

        $post = [
            'work_position' => 'パッキング',
            'hourly_wage' => '30.7',
            'pay_type' => 1,
            'is_car_required' => 2,
            'start_date' => '3999-12-31',
            'end_date' => null,
            'work_rating' => 1,
            'salary_rating' => 2,
            'hour_rating' => 3,
            'relation_rating' => 4,
            'overall_rating' => 5,
            'comment' => 'this farm is great',
            'farm_id' => $farm->id,
            'user_id' => $user->id,
        ];

        $response = $this->actingAs($user)->post(route('review.store', ['id' => $farm->id]), $post);

        $response->assertStatus(302);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('reviews', [
            'work_position' => 'パッキング',
            'hourly_wage' => '30.7',
            'pay_type' => 1,
        ]);


        $review = Review::firstOrFail();

        $response->assertRedirect(route('farm.detail', [
            'id' => $review->farm_id,
        ]));
    }

    /**
     * storeのバリデーション確認
     * 正しい情報の登録をエラーなしで通るか
     * pay_typeが2の時、hourly_wageはnullでOK
     */
    public function testStoreValidateSuccess(): void
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->create();

        $data = [
            'work_position' => 'パッキング',
            'hourly_wage' => null,
            'pay_type' => 2,
            'is_car_required' => 2,
            'start_date' => '3999-12-31',
            'end_date' => null,
            'work_rating' => 1,
            'salary_rating' => 2,
            'hour_rating' => 3,
            'relation_rating' => 4,
            'overall_rating' => 5,
            'comment' => 'this farm is great',
            'farm_id' => $farm->id,
            'user_id' => $user->id,
        ];

        $rules = (new ReviewStoreRequest())->rules();

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->passes());
    }

    /**
     * storeのバリデーション確認
     * 誤った情報の登録をエラーが出るか
     * pay_typeが1の時、hourly_wageはnullでNG
     */
    public function testStoreValidateFail(): void
    {
        $user = User::factory()->create();
        $farm = Farm::factory()->create();

        $data = [
            'work_position' => 'パッキング',
            'hourly_wage' => null,
            'pay_type' => 1,
            'is_car_required' => 2,
            'start_date' => '3999-12-31',
            'end_date' => null,
            'work_rating' => 1,
            'salary_rating' => 2,
            'hour_rating' => 3,
            'relation_rating' => 4,
            'overall_rating' => 5,
            'comment' => 'this farm is great',
            'farm_id' => $farm->id,
            'user_id' => $user->id,
        ];

        $rules = (new ReviewStoreRequest())->rules();

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->passes());
    }
}
