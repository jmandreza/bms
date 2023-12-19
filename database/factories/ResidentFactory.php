<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fname' => fake()->firstName,
            'mname' => fake()->lastName,
            'lname' => fake()->lastName,
            'birthdate' => fake()->date($format = 'Y-m-d', $max = 'now'),
            'gender' => fake()->randomElement($array = ['male', 'female', 'others']),
            'phone' => fake()->e164PhoneNumber,
            'household_no' => fake()->numberBetween($min = 1, $max = 400),
            'zone' => fake()->numberBetween($min = 1, $max = 7),
            'civil_status' => fake()->randomElement($array = ['single', 'married', 'widowed', 'separated']),
            'occupation' => fake()->jobTitle,
            'nationality' => fake()->randomElement($array = ['Filipino']),
            'fourps_member' => fake()->boolean($chanceOfGettingTrue = 50),
            'fully_vaxxed' => fake()->boolean($chanceOfGettingTrue = 50),
            'voter' => fake()->boolean($chanceOfGettingTrue = 50),
        ];
    }
}
