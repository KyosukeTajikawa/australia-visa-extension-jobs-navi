<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('states')->upsert([
            ['id' => 1, 'name' => 'New South Wales'],
            ['id' => 2, 'name' => 'Victoria'],
            ['id' => 3, 'name' => 'Queensland'],
            ['id' => 4, 'name' => 'South Australia'],
            ['id' => 5, 'name' => 'Western Australia'],
            ['id' => 6, 'name' => 'Northern Territory'],
            ['id' => 7, 'name' => 'Tasmania'],
            ['id' => 8, 'name' => 'Australian Capital Territory'],
        ], ['id'], ['name']);
    }
}
