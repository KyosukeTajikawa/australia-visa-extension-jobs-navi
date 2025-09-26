<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->insert([
            ['id' => 1, 'name' => 'NSW'],
            ['id' => 2, 'name' => 'VIC'],
            ['id' => 3, 'name' => 'QLD'],
            ['id' => 4, 'name' => 'SA'],
            ['id' => 5, 'name' => 'WA'],
            ['id' => 6, 'name' => 'NT'],
            ['id' => 7, 'name' => 'TAS'],
            ['id' => 8, 'name' => 'ACT'],
        ], ['id'], ['name']);
    }
}
