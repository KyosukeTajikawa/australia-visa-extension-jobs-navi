<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('application_methods')->insert([
            ['id' => 1, 'name' => 'Facebook'],
            ['id' => 2, 'name' => 'メール'],
            ['id' => 3, 'name' => 'SEEK'],
            ['id' => 4, 'name' => '電話'],
            ['id' => 5, 'name' => '直接レジュメを配る'],
            ['id' => 6, 'name' => '知り合いからの紹介'],
            ['id' => 7, 'name' => 'ファーム公式サイトの応募フォーム'],
            ['id' => 99, 'name' => 'その他'],
        ], ['id'], ['name']);
    }
}
