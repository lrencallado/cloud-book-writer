<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Fiction',
                'Non-fiction',
                'Science Fiction',
                'Novel',
                'Mystery',
                'Horror',
                'Thriller',
                'Drama',
                'Fairy tale',
                'Fantasy',
            ])
        ];
    }
}
