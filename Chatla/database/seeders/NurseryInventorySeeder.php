<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NurseryInventorySeeder extends Seeder
{
    public function run(): void
    {
        $inventories = [
            // Rozana Garden (Marrakech)
            ['nursery_id' => 1, 'plant_id' => 1,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 1, 'plant_id' => 2,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 1, 'plant_id' => 3,  'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 1, 'plant_id' => 4,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 1, 'plant_id' => 9,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 1, 'plant_id' => 19, 'stock_quantity' => 'low_stock', 'growth_status' => 'mature'],

            // Fleurs du Rif (Chefchaouen)
            ['nursery_id' => 2, 'plant_id' => 7,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 2, 'plant_id' => 9,  'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 2, 'plant_id' => 10, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 2, 'plant_id' => 12, 'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 2, 'plant_id' => 26, 'stock_quantity' => 'pre_ordered','growth_status' => 'seedling'],

            // Oasis Verte (Agadir)
            ['nursery_id' => 3, 'plant_id' => 19, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 3, 'plant_id' => 20, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 3, 'plant_id' => 22, 'stock_quantity' => 'low_stock', 'growth_status' => 'mature'],
            ['nursery_id' => 3, 'plant_id' => 23, 'stock_quantity' => 'pre_ordered','growth_status' => 'seedling'],
            ['nursery_id' => 3, 'plant_id' => 24, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 3, 'plant_id' => 21, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],

            // Jardin Andalous (Fès)
            ['nursery_id' => 4, 'plant_id' => 7,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 4, 'plant_id' => 10, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 4, 'plant_id' => 18, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 4, 'plant_id' => 27, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 4, 'plant_id' => 8,  'stock_quantity' => 'low_stock', 'growth_status' => 'seedling'],

            // Vert Atlas (Beni Mellal)
            ['nursery_id' => 5, 'plant_id' => 13, 'stock_quantity' => 'pre_ordered','growth_status' => 'seedling'],
            ['nursery_id' => 5, 'plant_id' => 14, 'stock_quantity' => 'low_stock', 'growth_status' => 'seedling'],
            ['nursery_id' => 5, 'plant_id' => 26, 'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 5, 'plant_id' => 11, 'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 5, 'plant_id' => 12, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],

            // Bourgeons de Casablanca (Casablanca)
            ['nursery_id' => 6, 'plant_id' => 1,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 6, 'plant_id' => 15, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 6, 'plant_id' => 16, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 6, 'plant_id' => 25, 'stock_quantity' => 'low_stock', 'growth_status' => 'mature'],
            ['nursery_id' => 6, 'plant_id' => 17, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 6, 'plant_id' => 2,  'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],

            // Palmeraie Draa (Ouarzazate)
            ['nursery_id' => 7, 'plant_id' => 23, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 7, 'plant_id' => 24, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 7, 'plant_id' => 5,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 7, 'plant_id' => 6,  'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 7, 'plant_id' => 13, 'stock_quantity' => 'low_stock', 'growth_status' => 'vegetative'],

            // Roses de M'Gouna (Kelaat M'Gouna)
            ['nursery_id' => 8, 'plant_id' => 7,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 8, 'plant_id' => 9,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 8, 'plant_id' => 12, 'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 8, 'plant_id' => 27, 'stock_quantity' => 'low_stock', 'growth_status' => 'mature'],

            // Jardins du Bouregreg (Rabat)
            ['nursery_id' => 9, 'plant_id' => 17, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 9, 'plant_id' => 21, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 9, 'plant_id' => 19, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 9, 'plant_id' => 10, 'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 9, 'plant_id' => 11, 'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 9, 'plant_id' => 20, 'stock_quantity' => 'low_stock', 'growth_status' => 'mature'],

            // Cactus du Souss (Taroudant)
            ['nursery_id' => 10, 'plant_id' => 5,  'stock_quantity' => 'in_stock',  'growth_status' => 'mature'],
            ['nursery_id' => 10, 'plant_id' => 6,  'stock_quantity' => 'in_stock',  'growth_status' => 'vegetative'],
            ['nursery_id' => 10, 'plant_id' => 14, 'stock_quantity' => 'pre_ordered','growth_status' => 'seedling'],
        ];

        foreach ($inventories as $item) {
            DB::table('nursery_inventories')->insert([
                'nursery_id'     => $item['nursery_id'],
                'plant_id'       => $item['plant_id'],
                'stock_quantity' => $item['stock_quantity'],
                'growth_status'  => $item['growth_status'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}