<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\Auth\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(UserRepositoryInterface::class);
    }

    /**
     * registerUser()のテスト
     * registerUser() 登録できている
     */
    public function testGetCreateById(): void
    {
        $user = [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'gender' => 1,
            'birthday' => '2000-10-10',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $result = $this->repository->registerUser($user);

        $this->assertSame($result['nickname'], $user['nickname']);
        $this->assertSame($result['email'], $user['email']);
        $this->assertSame($result['gender'], $user['gender']);
        $this->assertSame($result['birthday'], $user['birthday']);
    }

    /**
     * getUser()のテスト
     * getUser() 取得できている
     */
    public function testGetUser(): void
    {

        $user = User::factory()->sequence([
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'gender' => 1,
            'birthday' => '2000-10-10',
            'password' => 'password',
        ])->create();

        $this->actingAs($user);

        $result = $this->repository->getUser();

        $this->assertSame($result['nickname'], $user['nickname']);
        $this->assertSame($result['email'], $user['email']);
        $this->assertSame($result['gender'], $user['gender']);
        $this->assertSame($result['birthday'], $user['birthday']);
    }

    /**
     * updateUser()のテスト
     * updateUser() 更新できている
     */
    public function testUpdateUser(): void
    {

        $user = [
            'nickname' => 'Test User',
            'email' => 'test@example.com',
            'gender' => 1,
            'birthday' => '2000-10-10',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $previousUser = $this->repository->registerUser($user);

        $user = [
            'nickname' => 'Test',
            'email' => 'test@example.com',
            'gender' => 2,
            'birthday' => '2000-10-10',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $result = $this->repository->updateUser($user, $previousUser);

        $this->assertSame($result['nickname'], 'Test');
        $this->assertSame($result['gender'], 2);
    }

    /**
     * destroyUser()のテスト
     * destroyUser() 削除できている
     */
    public function testDestroyUser(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->repository->destroyUser();

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }
}
