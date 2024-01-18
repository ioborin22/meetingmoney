<?php

namespace Database\Seeders;

use App\Models\UserRating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание определенного количества записей рейтингов пользователей
        UserRating::factory()->count(100)->create(); // Например, создаем 100 записей
    }
}
