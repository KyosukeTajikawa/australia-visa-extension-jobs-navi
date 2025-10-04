<?php

namespace Database\Seeders;

use App\Models\Farm;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // NOTE: テストデータを作り直す際に必要なので取っておく
        // User::factory(10)->create();

        // $this->call(CropSeeder::class);
        // $this->call(StateSeeder::class);

        // Farm::factory(10)->create();
        // Review::factory(10)->create();

        User::create([
            'nickname' => 'テストユーザー',
            'email' => 'test@example.com',
            'gender' => 1,
            'birthday' => "1929-01-01",
            'password' => 'password123',
        ]);
    }
}
