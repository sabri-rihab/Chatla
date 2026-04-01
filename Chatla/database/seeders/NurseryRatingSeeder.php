<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NurseryRatingSeeder extends Seeder
{
    public function run(): void
    {
        // user IDs 12-31 are the 20 simple users
        // nursery IDs 1-10

        $ratings = [
            // Rozana Garden (1) - excellent ratings
            ['nursery_id' => 1, 'user_id' => 12, 'rate' => 5],
            ['nursery_id' => 1, 'user_id' => 13, 'rate' => 5],
            ['nursery_id' => 1, 'user_id' => 14, 'rate' => 4],
            ['nursery_id' => 1, 'user_id' => 15, 'rate' => 5],
            ['nursery_id' => 1, 'user_id' => 16, 'rate' => 4],

            // Fleurs du Rif (2) - good ratings
            ['nursery_id' => 2, 'user_id' => 12, 'rate' => 4],
            ['nursery_id' => 2, 'user_id' => 17, 'rate' => 4],
            ['nursery_id' => 2, 'user_id' => 18, 'rate' => 3],
            ['nursery_id' => 2, 'user_id' => 19, 'rate' => 5],

            // Oasis Verte (3) - mixed
            ['nursery_id' => 3, 'user_id' => 12, 'rate' => 4],
            ['nursery_id' => 3, 'user_id' => 20, 'rate' => 5],
            ['nursery_id' => 3, 'user_id' => 21, 'rate' => 3],
            ['nursery_id' => 3, 'user_id' => 22, 'rate' => 4],

            // Jardin Andalous (4) - excellent
            ['nursery_id' => 4, 'user_id' => 13, 'rate' => 5],
            ['nursery_id' => 4, 'user_id' => 23, 'rate' => 5],
            ['nursery_id' => 4, 'user_id' => 24, 'rate' => 5],
            ['nursery_id' => 4, 'user_id' => 25, 'rate' => 4],

            // Vert Atlas (5) - average
            ['nursery_id' => 5, 'user_id' => 14, 'rate' => 3],
            ['nursery_id' => 5, 'user_id' => 26, 'rate' => 2],
            ['nursery_id' => 5, 'user_id' => 27, 'rate' => 3],
            ['nursery_id' => 5, 'user_id' => 28, 'rate' => 4],

            // Bourgeons de Casablanca (6) - very good
            ['nursery_id' => 6, 'user_id' => 15, 'rate' => 4],
            ['nursery_id' => 6, 'user_id' => 29, 'rate' => 5],
            ['nursery_id' => 6, 'user_id' => 30, 'rate' => 4],
            ['nursery_id' => 6, 'user_id' => 31, 'rate' => 3],

            // Palmeraie Draa (7) - excellent, desert gem
            ['nursery_id' => 7, 'user_id' => 16, 'rate' => 5],
            ['nursery_id' => 7, 'user_id' => 17, 'rate' => 5],
            ['nursery_id' => 7, 'user_id' => 20, 'rate' => 5],
            ['nursery_id' => 7, 'user_id' => 22, 'rate' => 4],

            // Roses de M'Gouna (8) - legendary, top rated
            ['nursery_id' => 8, 'user_id' => 12, 'rate' => 5],
            ['nursery_id' => 8, 'user_id' => 18, 'rate' => 5],
            ['nursery_id' => 8, 'user_id' => 21, 'rate' => 5],
            ['nursery_id' => 8, 'user_id' => 23, 'rate' => 5],
            ['nursery_id' => 8, 'user_id' => 25, 'rate' => 5],

            // Jardins du Bouregreg (9) - very good
            ['nursery_id' => 9, 'user_id' => 13, 'rate' => 4],
            ['nursery_id' => 9, 'user_id' => 19, 'rate' => 5],
            ['nursery_id' => 9, 'user_id' => 24, 'rate' => 4],
            ['nursery_id' => 9, 'user_id' => 26, 'rate' => 3],

            // Cactus du Souss (10) - pending, fewer ratings
            ['nursery_id' => 10, 'user_id' => 27, 'rate' => 3],
            ['nursery_id' => 10, 'user_id' => 28, 'rate' => 4],
        ];

        foreach ($ratings as $rating) {
            DB::table('nursery_ratings')->insert([
                'nursery_id' => $rating['nursery_id'],
                'user_id'    => $rating['user_id'],
                'rate'       => $rating['rate'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
