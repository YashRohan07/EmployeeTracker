<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeDetail>
 */
class EmployeeDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designation' => $this->faker->jobTitle,
            'salary' => $this->faker->randomFloat(2, 30000, 200000),
            'address' => $this->faker->address,
            'joined_date' => $this->faker->date(),
        ];
    }
}
