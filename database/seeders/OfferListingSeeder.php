<?php

namespace Database\Seeders;

use App\Models\OfferListing;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание 50 записей в таблице offer_listings
        OfferListing::factory()->count(50)->create();
    }
}
