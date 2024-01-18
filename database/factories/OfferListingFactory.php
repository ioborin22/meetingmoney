<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfferListing>
 */
class OfferListingFactory extends Factory
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
            'operation_type' => $this->faker->randomElement(['buy', 'sell']),
            'offered_token' => $this->faker->word,
            'offered_token_currency' => $this->faker->currencyCode,
            'requested_token' => $this->faker->word,
            'requested_token_currency' => $this->faker->currencyCode,
            'amount' => $this->faker->randomFloat(8, 0, 1000), // Пример значений
            'unit_price' => $this->faker->randomFloat(2, 0, 1000),
            'total_price' => $this->faker->randomFloat(2, 0, 1000),
            'status' => $this->faker->randomElement(['active', 'pending', 'completed']),
            'offer_date' => $this->faker->dateTime,
            'comments' => $this->faker->sentence,
        ];
    }
}
