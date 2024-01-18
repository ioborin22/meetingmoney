<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRating>
 */
class UserRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), // Предполагается, что у вас есть UserFactory
            'rating' => $this->faker->randomElement(['+', '-']), // Тип отзыва
            'comment' => $this->faker->optional()->sentence, // Случайный комментарий, иногда может быть null
        ];
    }
}
