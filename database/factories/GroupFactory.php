<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->sentence($nbWords = 4),
            'description' => fake()->text($maxNbChars = 500),
            'created_at' => fake()->dateTimeBetween('-3 weeks')
        ];
    }
}
