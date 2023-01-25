<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('staffs')->insert([
            'staff_code' => '0000',
            'name' => 'taro_test',
            'role_id' => '0',
            'evaluation' => '良',
            'affiliation' => 'A保育園',
            'password' => \Hash::make('testtest'),
        ]);

        DB::table('staffs')->insert([
            'staff_code' => '1000',
            'name' => '大友',
            'role_id' => '0',
            'affiliation' => 'A保育園',
            'password' => \Hash::make('testtest'),
        ]);

        DB::table('staffs')->insert([
            'staff_code' => '1100',
            'name' => '採択',
            'role_id' => '1',
            'evaluation' => '',
            'affiliation' => 'B保育園',
            'password' => \Hash::make('testtest'),
        ]);

        DB::table('staffs')->insert([
            'staff_code' => '1110',
            'name' => 'のみ',
            'role_id' => '2',
            'evaluation' => '',
            'affiliation' => 'C保育園',
            'password' => \Hash::make('testtest'),
        ]);
    }
}
