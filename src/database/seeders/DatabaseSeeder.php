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
        $this->call(CropSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(ApplicationMethodSeeder::class);
    }
}
