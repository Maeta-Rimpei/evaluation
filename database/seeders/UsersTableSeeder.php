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
        DB::table('users')->insert([
            'staff_id' => '0000',
            'role_id' => '0',
            'name' => 'taro_test',
            'evaluation' => '良',
            'password' => \Hash::make('testtest'),
        ]);
    }
}
