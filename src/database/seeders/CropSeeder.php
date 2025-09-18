<?php

namespace Database\Seeders;

use App\Models\Crop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $json = Storage::disk('local')->get('storage/app/json/crops.json');
        // $crops = json_decode($json, true);

        // foreach ($crops as $crop) {
        //     Crop::query()->updateOrCreate([
        //         'name' => $crop['name'],
        //     ]);
        // }

        // Path to your JSON file
        $jsonFile = base_path('storage/app/json/crops.json');

        // Read and decode the JSON file
        $jsonData = json_decode(File::get($jsonFile), true);

        // Insert data into the database
        DB::table('crops')->insert($jsonData);
    }
}
