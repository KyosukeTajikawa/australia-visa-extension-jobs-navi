<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserImage;
use App\Repositories\Auth\UserImageRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserImageRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserImageRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(UserImageRepositoryInterface::class);
    }

    /**
     * registerImage()のテスト
     * registerImage() 登録できている
     */
    public function testRegisterImage(): void
    {
        $user = User::factory()->create();

        $UserImage = [
            'user_id' => $user->id,
            'url' => 'user/1/sample1.jpg',
            'path' => 'sample1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $this->repository->registerImage($UserImage);

        $this->assertDatabaseHas('user_images', [
            'user_id' => $user->id,
            'url' => $UserImage['url'],
            'path' => $UserImage['path'],
        ]);
    }

    /**
     * updateImage()のテスト
     * updateImage() 更新できている
     */
    public function testUpdateImage(): void
    {
        $user = User::factory()->create();

        $userImage = [
            'user_id' => $user->id,
            'url' => 'user/1/sample1.jpg',
            'path' => 'sample1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $previousImage = UserImage::create($userImage);

        $newImage = [
            'user_id' => $user->id,
            'url' => 'user/2/sample1.jpg',
            'path' => 'sample2.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $this->repository->updateImage($newImage, $previousImage);

        $this->assertDatabaseHas('user_images', [
            'user_id' => $user->id,
            'url' => 'user/2/sample1.jpg',
            'path' => 'sample2.jpg',
        ]);
    }

}
