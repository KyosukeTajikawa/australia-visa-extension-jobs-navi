<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cropsFile = base_path('storage/app/json/crops.json');

        $cropsData = json_decode(File::get($cropsFile), true);

        DB::table('crops')->insert($cropsData);
    }
}
