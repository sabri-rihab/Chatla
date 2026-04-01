<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryImageSeeder extends Seeder
{
    public function run(): void
    {
        // nursery_inventory_id => [image URLs]
        // IDs correspond to insertion order in NurseryInventorySeeder
        $images = [
            // Nursery 1 (Rozana Garden) inventory items 1-6
            1  => ['https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=600'],
            2  => ['https://images.unsplash.com/photo-1599598425947-5202edd56bdb?w=600'],
            3  => ['https://images.unsplash.com/photo-1463936575829-25148e1db1b8?w=600'],
            4  => ['https://images.unsplash.com/photo-1616038413536-4a81d1e3b0d8?w=600'],
            5  => ['https://images.unsplash.com/photo-1499002238440-d264edd596ec?w=600'],
            6  => ['https://images.unsplash.com/photo-1547514701-42782101795e?w=600'],

            // Nursery 2 (Fleurs du Rif) inventory items 7-11
            7  => ['https://images.unsplash.com/photo-1490750967868-88df5691890f?w=600'],
            8  => ['https://images.unsplash.com/photo-1468657988500-aca2be09f4c6?w=600'],
            9  => ['https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600'],
            10 => ['https://images.unsplash.com/photo-1561181286-d3c86269c3b3?w=600'],
            11 => ['https://images.unsplash.com/photo-1583853291994-f55bc4a74b39?w=600'],

            // Nursery 3 (Oasis Verte) items 12-17
            12 => ['https://images.unsplash.com/photo-1547514701-42782101795e?w=600'],
            13 => ['https://images.unsplash.com/photo-1571546703736-5a01671e7ab7?w=600'],
            14 => ['https://images.unsplash.com/photo-1508739773434-c26b3d09e071?w=600'],
            15 => ['https://images.unsplash.com/photo-1521305916504-4a1121188589?w=600'],
            16 => ['https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600'],
            17 => ['https://images.unsplash.com/photo-1598521121068-4cb9e3bbf3c8?w=600'],

            // Nursery 4 (Jardin Andalous) items 18-22
            18 => ['https://images.unsplash.com/photo-1455103345-04a62fe7b18f?w=600'],
            19 => ['https://images.unsplash.com/photo-1592997572594-34be6d0683af?w=600'],
            20 => ['https://images.unsplash.com/photo-1597449684683-78da08e99f09?w=600'],
            21 => ['https://images.unsplash.com/photo-1570990039543-9c8c41e53f78?w=600'],
            22 => ['https://images.unsplash.com/photo-1628688640046-d5b9dd7ebdf1?w=600'],

            // Nursery 5 (Vert Atlas) items 23-27
            23 => ['https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=600'],
            24 => ['https://images.unsplash.com/photo-1504567961542-e24d9439a724?w=600'],
            25 => ['https://images.unsplash.com/photo-1577556264099-d478aff71c20?w=600'],
            26 => ['https://images.unsplash.com/photo-1471193945509-9ad0617afabf?w=600'],
            27 => ['https://images.unsplash.com/photo-1570996338049-f81e4c9f8c96?w=600'],

            // Nursery 6 (Bourgeons de Casablanca) items 28-33
            28 => ['https://images.unsplash.com/photo-1545239351-1141bd82e8a6?w=600'],
            29 => ['https://images.unsplash.com/photo-1604671801908-6f0c6a092c05?w=600'],
            30 => ['https://images.unsplash.com/photo-1609259232303-6a1b7db1c17e?w=600'],
            31 => ['https://images.unsplash.com/photo-1490885578174-acda8905c2c6?w=600'],
            32 => ['https://images.unsplash.com/photo-1592198084033-aade902d1aae?w=600'],
            33 => ['https://images.unsplash.com/photo-1597595462805-b88d9bc4d08e?w=600'],

            // Nursery 7 (Palmeraie Draa) items 34-38
            34 => ['https://images.unsplash.com/photo-1509420316987-d27b02f81864?w=600'],
            35 => ['https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600'],
            36 => ['https://images.unsplash.com/photo-1528038785595-f8c82f547b17?w=600'],
            37 => ['https://images.unsplash.com/photo-1536836255260-eb2d3a7e8dc0?w=600'],
            38 => ['https://images.unsplash.com/photo-1585320806297-9794b3e4aaae?w=600'],

            // Nursery 8 (Roses de M'Gouna) items 39-42
            39 => ['https://images.unsplash.com/photo-1490750967868-88df5691890f?w=600', 'https://images.unsplash.com/photo-1562887009-9b2f0df07e48?w=600'],
            40 => ['https://images.unsplash.com/photo-1499002238440-d264edd596ec?w=600'],
            41 => ['https://images.unsplash.com/photo-1570996338049-f81e4c9f8c96?w=600'],
            42 => ['https://images.unsplash.com/photo-1598521121020-e4e73c1e77c0?w=600'],

            // Nursery 9 (Jardins du Bouregreg) items 43-48
            43 => ['https://images.unsplash.com/photo-1567748157439-651aca2ff064?w=600'],
            44 => ['https://images.unsplash.com/photo-1598261498-5cf1944b2e5e?w=600'],
            45 => ['https://images.unsplash.com/photo-1580201092675-a0a6a6cafbb1?w=600'],
            46 => ['https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600'],
            47 => ['https://images.unsplash.com/photo-1471193945509-9ad0617afabf?w=600'],
            48 => ['https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=600'],

            // Nursery 10 (Cactus du Souss) items 49-51
            49 => ['https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600'],
            50 => ['https://images.unsplash.com/photo-1587334207473-aa27ad87f5b4?w=600'],
            51 => ['https://images.unsplash.com/photo-1504567961542-e24d9439a724?w=600'],
        ];

        foreach ($images as $inventoryId => $urls) {
            foreach ($urls as $url) {
                DB::table('inventory_images')->insert([
                    'nursery_inventory_id' => $inventoryId,
                    'image_path'           => $url,
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);
            }
        }
    }
}
