<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultPlantImageSeeder extends Seeder
{
    public function run(): void
    {
        // Images sourced from Unsplash CDN (free, no auth required)
        // format: plant_id => [image_urls]
        // Plant IDs follow insertion order in PlantSeeder

        $images = [
            // 1 - Monstera Deliciosa
            1 => [
                'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=800',
                'https://images.unsplash.com/photo-1545239351-1141bd82e8a6?w=800',
                'https://images.unsplash.com/photo-1637764655993-c1411fe3f5fd?w=800',
            ],
            // 2 - Philodendron Imperial Green
            2 => [
                'https://images.unsplash.com/photo-1599598425947-5202edd56bdb?w=800',
                'https://images.unsplash.com/photo-1597595462805-b88d9bc4d08e?w=800',
            ],
            // 3 - Pothos Aureus
            3 => [
                'https://images.unsplash.com/photo-1463936575829-25148e1db1b8?w=800',
                'https://images.unsplash.com/photo-1584547980690-0e8c2e05efde?w=800',
            ],
            // 4 - Peace Lily
            4 => [
                'https://images.unsplash.com/photo-1616038413536-4a81d1e3b0d8?w=800',
                'https://images.unsplash.com/photo-1651247023434-cb5efea4dae5?w=800',
            ],
            // 5 - Cactus Opuntia
            5 => [
                'https://images.unsplash.com/photo-1528038785595-f8c82f547b17?w=800',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800',
            ],
            // 6 - Cereus Peruvianus
            6 => [
                'https://images.unsplash.com/photo-1536836255260-eb2d3a7e8dc0?w=800',
                'https://images.unsplash.com/photo-1587334207473-aa27ad87f5b4?w=800',
            ],
            // 7 - Rosa Damascena
            7 => [
                'https://images.unsplash.com/photo-1490750967868-88df5691890f?w=800',
                'https://images.unsplash.com/photo-1455103345-04a62fe7b18f?w=800',
                'https://images.unsplash.com/photo-1562887009-9b2f0df07e48?w=800',
            ],
            // 8 - Prunus Persica
            8 => [
                'https://images.unsplash.com/photo-1628688640046-d5b9dd7ebdf1?w=800',
                'https://images.unsplash.com/photo-1600189020773-ac1f22f5d5d3?w=800',
            ],
            // 9 - Lavandula
            9 => [
                'https://images.unsplash.com/photo-1499002238440-d264edd596ec?w=800',
                'https://images.unsplash.com/photo-1468657988500-aca2be09f4c6?w=800',
            ],
            // 10 - Mentha Nana
            10 => [
                'https://images.unsplash.com/photo-1592997572594-34be6d0683af?w=800',
                'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800',
            ],
            // 11 - Helianthus (Sunflower)
            11 => [
                'https://images.unsplash.com/photo-1471193945509-9ad0617afabf?w=800',
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800',
            ],
            // 12 - Calendula
            12 => [
                'https://images.unsplash.com/photo-1570996338049-f81e4c9f8c96?w=800',
                'https://images.unsplash.com/photo-1561181286-d3c86269c3b3?w=800',
            ],
            // 13 - Caroubier
            13 => [
                'https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=800',
            ],
            // 14 - Acacia
            14 => [
                'https://images.unsplash.com/photo-1504567961542-e24d9439a724?w=800',
            ],
            // 15 - Phalaenopsis Orchid
            15 => [
                'https://images.unsplash.com/photo-1567429033(zip)?w=800',
                'https://images.unsplash.com/photo-1604671801908-6f0c6a092c05?w=800',
                'https://images.unsplash.com/photo-1548502961-6a3df1ba64dc?w=800',
            ],
            // 16 - Poinsettia
            16 => [
                'https://images.unsplash.com/photo-1609259232303-6a1b7db1c17e?w=800',
                'https://images.unsplash.com/photo-1514890676792-f6d07bc72f0b?w=800',
            ],
            // 17 - Ficus Benjamina
            17 => [
                'https://images.unsplash.com/photo-1592198084033-aade902d1aae?w=800',
                'https://images.unsplash.com/photo-1567748157439-651aca2ff064?w=800',
            ],
            // 18 - Ficus Carica
            18 => [
                'https://images.unsplash.com/photo-1597449684683-78da08e99f09?w=800',
                'https://images.unsplash.com/photo-1601929862931-2a2c7de5b7e3?w=800',
            ],
            // 19 - Citrus Sinensis
            19 => [
                'https://images.unsplash.com/photo-1547514701-42782101795e?w=800',
                'https://images.unsplash.com/photo-1580201092675-a0a6a6cafbb1?w=800',
            ],
            // 20 - Citrus Limon
            20 => [
                'https://images.unsplash.com/photo-1571546703736-5a01671e7ab7?w=800',
                'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=800',
            ],
            // 21 - Nerium Oleander
            21 => [
                'https://images.unsplash.com/photo-1598521121068-4cb9e3bbf3c8?w=800',
                'https://images.unsplash.com/photo-1598261498-5cf1944b2e5e?w=800',
            ],
            // 22 - Plumeria Rubra
            22 => [
                'https://images.unsplash.com/photo-1508739773434-c26b3d09e071?w=800',
                'https://images.unsplash.com/photo-1561131668-f63504fc549d?w=800',
            ],
            // 23 - Phoenix Dactylifera
            23 => [
                'https://images.unsplash.com/photo-1521305916504-4a1121188589?w=800',
                'https://images.unsplash.com/photo-1509420316987-d27b02f81864?w=800',
            ],
            // 24 - Chamaerops Humilis
            24 => [
                'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800',
            ],
            // 25 - Ananas (Ornamental)
            25 => [
                'https://images.unsplash.com/photo-1490885578174-acda8905c2c6?w=800',
                'https://images.unsplash.com/photo-1589820296156-2454bb8a6ad1?w=800',
            ],
            // 26 - Eucalyptus
            26 => [
                'https://images.unsplash.com/photo-1583853291994-f55bc4a74b39?w=800',
                'https://images.unsplash.com/photo-1577556264099-d478aff71c20?w=800',
            ],
            // 27 - Myrtus Communis
            27 => [
                'https://images.unsplash.com/photo-1570990039543-9c8c41e53f78?w=800',
                'https://images.unsplash.com/photo-1598521121020-e4e73c1e77c0?w=800',
            ],
        ];

        foreach ($images as $plantId => $urls) {
            foreach ($urls as $url) {
                DB::table('default_plant_images')->insert([
                    'plant_id'   => $plantId,
                    'image_path' => $url,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
