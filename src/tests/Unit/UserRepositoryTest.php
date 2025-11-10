<?php

namespace Tests\Unit;

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
     * registerUser() がユーザー情報を登録できている
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

}
