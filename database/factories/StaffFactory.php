<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'staff_code' => rand(0, 9999),
            'role_id' => $this->faker->numberBetween(0, 2),
            'affiliation' => $this->faker->city(),
            'total_evaluation' => null,
            'evaluation' => null,
            'password' => \Hash::make('testtest'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
