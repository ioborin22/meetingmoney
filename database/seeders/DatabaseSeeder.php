<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Создание пользователей
        \App\Models\User::factory(10)->create();

        // Посев OfferListings
        $this->call(OfferListingSeeder::class);

        // Посев UserRatings
        $this->call(UserRatingSeeder::class);
    }
}
