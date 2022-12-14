<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'staff_id' => '1000',
            'name' => 'test_taro',
            'affiliation' => 'X保育園',
            'role_id' => '0',
            'password' => \Hash::make('testtest'),
        ]);
    }
}
