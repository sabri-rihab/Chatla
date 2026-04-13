<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,            // 1 admin + 10 nursery_owners + 20 simple users
            CitySeeder::class,            // All Moroccan cities
            PlantFamilySeeder::class,     // 15 plant families
            PlantSeeder::class,           // 27 plants with full care details
            DefaultPlantImageSeeder::class, // Unsplash images for each plant
            NurserySeeder::class,         // 10 nurseries across Morocco
            NurseryInventorySeeder::class, // 50+ inventory records
            InventoryImageSeeder::class,  // Images per inventory item
            NurseryRatingSeeder::class,   // 42 user ratings across all nurseries
        ]);
    }
}
