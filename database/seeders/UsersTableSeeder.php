<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;
use App\Models\Staff;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::factory()->count(100)->create();
    }
}
