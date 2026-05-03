<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Plant;

class DefaultPlantImageSeeder extends Seeder
{
    public function run(): void
    {
        // Images sourced from Unsplash CDN (free, no auth required)
        // Each plant has exactly 1 primaryImage and 4 secondary images

        // $images = [
        //     // 1 - Monstera Deliciosa
        //     1 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1592098634508-5a2ea1ded8d4?w=800',
        //             'https://images.unsplash.com/photo-1531925882033-2c496b649b0a?w=800',
        //             'https://images.unsplash.com/photo-1511629179905-aae36987b118?w=800',
        //         ]
        //     ],
        //     // 2 - Philodendron Imperial Green
        //     2 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1563953382398-5626172d81b5?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1597595462805-b88d9bc4d08e?w=800',
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //             'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
        //             'https://images.unsplash.com/photo-1595433707813-e183350812cb?w=800',
        //         ]
        //     ],
        //     // 3 - Pothos Aureus
        //     3 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1566886387268-0dd39d35d23c?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1567748157439-651aca2ff064?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1592098634508-5a2ea1ded8d4?w=800',
        //         ]
        //     ],
        //     // 4 - Peace Lily
        //     4 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1618328875339-e56adde36c76?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1612686589826-fe4b9a4a59b6?w=800',
        //             'https://images.unsplash.com/photo-1584514250112-96cafb8997b9?w=800',
        //             'https://images.unsplash.com/photo-1611609213551-2212ab57d6e6?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         ]
        //     ],
        //     // 5 - Cactus Opuntia
        //     5 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1528038785595-f8c82f547b17?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1578562271052-e7fe2355d76f?w=800',
        //             'https://images.unsplash.com/photo-1587839191488-4be5ed77adc7?w=800',
        //             'https://images.unsplash.com/photo-1530607876167-9f1cd9d9a1f2?w=800',
        //             'https://images.unsplash.com/photo-1563953382398-5626172d81b5?w=800',
        //         ]
        //     ],
        //     // 6 - Cereus Peruvianus
        //     6 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1530607876167-9f1cd9d9a1f2?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1587839191488-4be5ed77adc7?w=800',
        //             'https://images.unsplash.com/photo-1578562271052-e7fe2355d76f?w=800',
        //             'https://images.unsplash.com/photo-1528038785595-f8c82f547b17?w=800',
        //             'https://images.unsplash.com/photo-1566886387268-0dd39d35d23c?w=800',
        //         ]
        //     ],
        //     // 7 - Rosa Damascena
        //     7 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1519052537078-e6302a4968d4?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1582159888966-ea3dc3a01fc5?w=800',
        //             'https://images.unsplash.com/photo-1562887009-9b2f0df07e48?w=800',
        //             'https://images.unsplash.com/photo-1490750967868-88df5691890f?w=800',
        //             'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=800',
        //         ]
        //     ],
        //     // 8 - Prunus Persica
        //     8 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1585059374701-cd4628902249?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1560806962-89e5c8bc3f7e?w=800',
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //         ]
        //     ],
        //     // 9 - Lavandula
        //     9 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1523634293359-54c73fc5fcff?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1592997572594-34be6d0683af?w=800',
        //             'https://images.unsplash.com/photo-1570996338049-f81e4c9f8c96?w=800',
        //             'https://images.unsplash.com/photo-1549887534-7df96b983501?w=800',
        //             'https://images.unsplash.com/photo-1533903514331-3bda8b732901?w=800',
        //         ]
        //     ],
        //     // 10 - Mentha Nana
        //     10 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1582159888966-ea3dc3a01fc5?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1584514250112-96cafb8997b9?w=800',
        //             'https://images.unsplash.com/photo-1598859942239-83cd5b7a70a2?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //         ]
        //     ],
        //     // 11 - Helianthus (Sunflower)
        //     11 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1597848212624-753a6d9d1d2f?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1514773376311-2bd14f73d5de?w=800',
        //             'https://images.unsplash.com/photo-1570996338049-f81e4c9f8c96?w=800',
        //             'https://images.unsplash.com/photo-1526336024174-e58f5cdd8d13?w=800',
        //             'https://images.unsplash.com/photo-1586348943529-beaae6c28db9?w=800',
        //         ]
        //     ],
        //     // 12 - Calendula
        //     12 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1570996338049-f81e4c9f8c96?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1490750967868-88df5691890f?w=800',
        //             'https://images.unsplash.com/photo-1519052537078-e6302a4968d4?w=800',
        //             'https://images.unsplash.com/photo-1597848212624-753a6d9d1d2f?w=800',
        //             'https://images.unsplash.com/photo-1514773376311-2bd14f73d5de?w=800',
        //         ]
        //     ],
        //     // 13 - Caroubier
        //     13 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1572414776270-df8eed0a85f5?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //             'https://images.unsplash.com/photo-1583853291994-f55bc4a74b39?w=800',
        //             'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
        //             'https://images.unsplash.com/photo-1582159888966-ea3dc3a01fc5?w=800',
        //         ]
        //     ],
        //     // 14 - Acacia
        //     14 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1572414776270-df8eed0a85f5?w=800',
        //             'https://images.unsplash.com/photo-1583853291994-f55bc4a74b39?w=800',
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         ]
        //     ],
        //     // 15 - Phalaenopsis Orchid
        //     15 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1604671801908-6f0c6a092c05?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=800',
        //             'https://images.unsplash.com/photo-1609259232303-6a1b7db1c17e?w=800',
        //             'https://images.unsplash.com/photo-1564078369132-cd4628902249?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         ]
        //     ],
        //     // 16 - Poinsettia
        //     16 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1609259232303-6a1b7db1c17e?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1604671801908-6f0c6a092c05?w=800',
        //             'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         ]
        //     ],
        //     // 17 - Ficus Benjamina
        //     17 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1596848212688-46ca9e4e5cf1?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1567748157439-651aca2ff064?w=800',
        //             'https://images.unsplash.com/photo-1592098634508-5a2ea1ded8d4?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //         ]
        //     ],
        //     // 18 - Ficus Carica
        //     18 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1585059374701-cd4628902249?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1596848212688-46ca9e4e5cf1?w=800',
        //             'https://images.unsplash.com/photo-1567748157439-651aca2ff064?w=800',
        //             'https://images.unsplash.com/photo-1563953382398-5626172d81b5?w=800',
        //         ]
        //     ],
        //     // 19 - Citrus Sinensis
        //     19 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1580201092675-a0a6a6cafbb1?w=800',
        //             'https://images.unsplash.com/photo-1565958011504-98d7ee93c5f8?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //         ]
        //     ],
        //     // 20 - Citrus Limon
        //     20 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1565958011504-98d7ee93c5f8?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1580201092675-a0a6a6cafbb1?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1592098634508-5a2ea1ded8d4?w=800',
        //         ]
        //     ],
        //     // 21 - Nerium Oleander
        //     21 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //             'https://images.unsplash.com/photo-1582159888966-ea3dc3a01fc5?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1604671801908-6f0c6a092c05?w=800',
        //         ]
        //     ],
        //     // 22 - Plumeria Rubra
        //     22 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1560806962-89e5c8bc3f7e?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1561181286-d3c86269c3b3?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //             'https://images.unsplash.com/photo-1604671801908-6f0c6a092c05?w=800',
        //         ]
        //     ],
        //     // 23 - Phoenix Dactylifera
        //     23 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1590362891990-f776e5541c6d?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1509420316987-d27b02f81864?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1592098634508-5a2ea1ded8d4?w=800',
        //         ]
        //     ],
        //     // 24 - Chamaerops Humilis
        //     24 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1590362891990-f776e5541c6d?w=800',
        //             'https://images.unsplash.com/photo-1509420316987-d27b02f81864?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //             'https://images.unsplash.com/photo-1592098634508-5a2ea1ded8d4?w=800',
        //         ]
        //     ],
        //     // 25 - Ananas (Ornamental)
        //     25 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1592098634508-5a2ea1ded8d4?w=800',
        //             'https://images.unsplash.com/photo-1590362891990-f776e5541c6d?w=800',
        //             'https://images.unsplash.com/photo-1509420316987-d27b02f81864?w=800',
        //             'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=800',
        //         ]
        //     ],
        //     // 26 - Eucalyptus
        //     26 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1583853291994-f55bc4a74b39?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
        //             'https://images.unsplash.com/photo-1572414776270-df8eed0a85f5?w=800',
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         ]
        //     ],
        //     // 27 - Myrtus Communis
        //     27 => [
        //         'primaryImage' => 'https://images.unsplash.com/photo-1572414776270-df8eed0a85f5?w=800',
        //         'images' => [
        //             'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
        //             'https://images.unsplash.com/photo-1583853291994-f55bc4a74b39?w=800',
        //             'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800',
        //             'https://images.unsplash.com/photo-1599599810694-b5ac4dd33c1f?w=800',
        //         ]
        //     ],
        // ];

        DB::table('default_plant_images')->truncate();

        $baseNames = [
            'monstera_deliciosa',
            'philodendron_imperial_green',
            'pothos_pureus',
            'peace_lily',
            'cactus_opuntia',
            'cereus_peruvianus',
            'rosa_damascena',
            'prunus_persica',
            'lavandula',
            'mentha_nana',
            'helianthus_Sunflower',
            'calendula',
            'caroubier',
            'acacia',
            'phalaenopsis_orchid',
            'poinsettia',
            'ficus_benjamina',
            'ficus_carica',
            'citrus_sinensis',
            'citrus_limon',
            'nerium_oleander',
            'plumeria_rubra',
            'phoenix_dactylifera',
            'chamaerops_humilis',
            'ananas_ornamental',
            'eucalyptus',
            'myrtus_communis'
        ];

        // Ensure we map them in the exact order they were inserted by PlantSeeder
        $plants = Plant::orderBy('id')->get();

        foreach ($plants as $index => $plant) {
            // Get the corresponding base name from the user's array
            $baseName = $baseNames[$index] ?? str_replace('-', '_', $plant->slug);
            
            // Insert exactly 1 primary image
            DB::table('default_plant_images')->insert([
                'plant_id'   => $plant->id,
                'image_path' => "default_plants/{$baseName}_primary.jpg",
                'is_primary' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert 4 secondary images
            for ($i = 2; $i <= 5; $i++) {
                DB::table('default_plant_images')->insert([
                    'plant_id'   => $plant->id,
                    'image_path' => "default_plants/{$baseName}_{$i}.jpg",
                    'is_primary' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}