<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NurseryInventorySeeder extends Seeder
{
    public function run(): void
    {
        $growthStatuses = ['seed', 'seedling', 'vegetative', 'mature'];

        // Map: nursery_id => [plant_ids it carries with quantities]
        $inventories = [
            // Rozana Garden (Marrakech) - tropical & ornamental focus
            ['nursery_id' => 1, 'plant_id' => 1,  'stock_quantity' => 12, 'growth_status' => 'mature'],     // Monstera
            ['nursery_id' => 1, 'plant_id' => 2,  'stock_quantity' => 8,  'growth_status' => 'mature'],     // Philodendron
            ['nursery_id' => 1, 'plant_id' => 3,  'stock_quantity' => 25, 'growth_status' => 'vegetative'], // Pothos
            ['nursery_id' => 1, 'plant_id' => 4,  'stock_quantity' => 15, 'growth_status' => 'mature'],     // Peace Lily
            ['nursery_id' => 1, 'plant_id' => 9,  'stock_quantity' => 20, 'growth_status' => 'mature'],     // Lavender
            ['nursery_id' => 1, 'plant_id' => 19, 'stock_quantity' => 6,  'growth_status' => 'mature'],     // Orange tree

            // Fleurs du Rif (Chefchaouen) - wild/mountain plants
            ['nursery_id' => 2, 'plant_id' => 7,  'stock_quantity' => 30, 'growth_status' => 'mature'],     // Damask Rose
            ['nursery_id' => 2, 'plant_id' => 9,  'stock_quantity' => 18, 'growth_status' => 'vegetative'], // Lavender
            ['nursery_id' => 2, 'plant_id' => 10, 'stock_quantity' => 50, 'growth_status' => 'mature'],     // Moroccan Mint
            ['nursery_id' => 2, 'plant_id' => 12, 'stock_quantity' => 22, 'growth_status' => 'vegetative'], // Calendula
            ['nursery_id' => 2, 'plant_id' => 26, 'stock_quantity' => 5,  'growth_status' => 'seedling'],   // Eucalyptus

            // Oasis Verte (Agadir) - tropical & fruit trees
            ['nursery_id' => 3, 'plant_id' => 19, 'stock_quantity' => 14, 'growth_status' => 'mature'],     // Orange
            ['nursery_id' => 3, 'plant_id' => 20, 'stock_quantity' => 10, 'growth_status' => 'mature'],     // Lemon
            ['nursery_id' => 3, 'plant_id' => 22, 'stock_quantity' => 7,  'growth_status' => 'mature'],     // Frangipani
            ['nursery_id' => 3, 'plant_id' => 23, 'stock_quantity' => 4,  'growth_status' => 'seedling'],   // Date Palm
            ['nursery_id' => 3, 'plant_id' => 24, 'stock_quantity' => 9,  'growth_status' => 'mature'],     // Dwarf Fan Palm
            ['nursery_id' => 3, 'plant_id' => 21, 'stock_quantity' => 12, 'growth_status' => 'mature'],     // Oleander

            // Jardin Andalous (Fès) - classical Moroccan garden plants
            ['nursery_id' => 4, 'plant_id' => 7,  'stock_quantity' => 25, 'growth_status' => 'mature'],     // Rose
            ['nursery_id' => 4, 'plant_id' => 10, 'stock_quantity' => 40, 'growth_status' => 'mature'],     // Mint
            ['nursery_id' => 4, 'plant_id' => 18, 'stock_quantity' => 8,  'growth_status' => 'mature'],     // Fig tree
            ['nursery_id' => 4, 'plant_id' => 27, 'stock_quantity' => 15, 'growth_status' => 'mature'],     // Myrtle
            ['nursery_id' => 4, 'plant_id' => 8,  'stock_quantity' => 6,  'growth_status' => 'seedling'],   // Peach tree

            // Vert Atlas (Beni Mellal) - Atlas region varieties
            ['nursery_id' => 5, 'plant_id' => 13, 'stock_quantity' => 3,  'growth_status' => 'seedling'],   // Carob
            ['nursery_id' => 5, 'plant_id' => 14, 'stock_quantity' => 5,  'growth_status' => 'seedling'],   // Acacia
            ['nursery_id' => 5, 'plant_id' => 26, 'stock_quantity' => 10, 'growth_status' => 'vegetative'], // Eucalyptus
            ['nursery_id' => 5, 'plant_id' => 11, 'stock_quantity' => 30, 'growth_status' => 'vegetative'], // Sunflower
            ['nursery_id' => 5, 'plant_id' => 12, 'stock_quantity' => 20, 'growth_status' => 'mature'],     // Calendula

            // Bourgeons de Casablanca (Casablanca) - premium indoor plants
            ['nursery_id' => 6, 'plant_id' => 1,  'stock_quantity' => 20, 'growth_status' => 'mature'],     // Monstera
            ['nursery_id' => 6, 'plant_id' => 15, 'stock_quantity' => 12, 'growth_status' => 'mature'],     // Orchid
            ['nursery_id' => 6, 'plant_id' => 16, 'stock_quantity' => 18, 'growth_status' => 'mature'],     // Poinsettia
            ['nursery_id' => 6, 'plant_id' => 25, 'stock_quantity' => 6,  'growth_status' => 'mature'],     // Ornamental Pineapple
            ['nursery_id' => 6, 'plant_id' => 17, 'stock_quantity' => 9,  'growth_status' => 'mature'],     // Ficus Benjamina
            ['nursery_id' => 6, 'plant_id' => 2,  'stock_quantity' => 14, 'growth_status' => 'vegetative'], // Philodendron

            // Palmeraie Draa (Ouarzazate) - desert & palm specialists
            ['nursery_id' => 7, 'plant_id' => 23, 'stock_quantity' => 15, 'growth_status' => 'mature'],     // Date Palm
            ['nursery_id' => 7, 'plant_id' => 24, 'stock_quantity' => 10, 'growth_status' => 'mature'],     // Dwarf Palm
            ['nursery_id' => 7, 'plant_id' => 5,  'stock_quantity' => 25, 'growth_status' => 'mature'],     // Opuntia Cactus
            ['nursery_id' => 7, 'plant_id' => 6,  'stock_quantity' => 8,  'growth_status' => 'vegetative'], // Cereus
            ['nursery_id' => 7, 'plant_id' => 13, 'stock_quantity' => 6,  'growth_status' => 'vegetative'], // Carob

            // Roses de M'Gouna (Kelaat M'Gouna) - rose specialists
            ['nursery_id' => 8, 'plant_id' => 7,  'stock_quantity' => 80, 'growth_status' => 'mature'],     // Damask Rose (specialty!)
            ['nursery_id' => 8, 'plant_id' => 9,  'stock_quantity' => 30, 'growth_status' => 'mature'],     // Lavender
            ['nursery_id' => 8, 'plant_id' => 12, 'stock_quantity' => 25, 'growth_status' => 'vegetative'], // Calendula
            ['nursery_id' => 8, 'plant_id' => 27, 'stock_quantity' => 10, 'growth_status' => 'mature'],     // Myrtle

            // Jardins du Bouregreg (Rabat) - mixed garden centre
            ['nursery_id' => 9, 'plant_id' => 17, 'stock_quantity' => 11, 'growth_status' => 'mature'],     // Ficus Benjamina
            ['nursery_id' => 9, 'plant_id' => 21, 'stock_quantity' => 20, 'growth_status' => 'mature'],     // Oleander
            ['nursery_id' => 9, 'plant_id' => 19, 'stock_quantity' => 8,  'growth_status' => 'mature'],     // Orange tree
            ['nursery_id' => 9, 'plant_id' => 10, 'stock_quantity' => 35, 'growth_status' => 'mature'],     // Mint
            ['nursery_id' => 9, 'plant_id' => 11, 'stock_quantity' => 15, 'growth_status' => 'vegetative'], // Sunflower
            ['nursery_id' => 9, 'plant_id' => 20, 'stock_quantity' => 7,  'growth_status' => 'mature'],     // Lemon

            // Cactus du Souss (Taroudant) - cactus & succulents (pending)
            ['nursery_id' => 10, 'plant_id' => 5,  'stock_quantity' => 35, 'growth_status' => 'mature'],    // Opuntia
            ['nursery_id' => 10, 'plant_id' => 6,  'stock_quantity' => 12, 'growth_status' => 'vegetative'],// Cereus
            ['nursery_id' => 10, 'plant_id' => 14, 'stock_quantity' => 8,  'growth_status' => 'seedling'],  // Acacia
        ];

        foreach ($inventories as $item) {
            DB::table('nursery_inventories')->insert([
                'nursery_id'    => $item['nursery_id'],
                'plant_id'      => $item['plant_id'],
                'stock_quantity' => $item['stock_quantity'],
                'growth_status' => $item['growth_status'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
