<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            [
                'key' => 'no_wa',
                'value' => '6287899295936', // ganti sesuai kebutuhan
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
