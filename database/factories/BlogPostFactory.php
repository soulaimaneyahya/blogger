<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence($nbWords = 4),
            'content' => fake()->text($maxNbChars = 500),
            'created_at' => fake()->dateTimeBetween('-3 weeks')
        ];
    }

    public function lorem()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'lorem ipsum dolor sit ament',
                'content' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.',
            ];
        });
    }
}
