<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlantFamilySeeder extends Seeder
{
    public function run(): void
    {
        $families = [
            'Araceae',
            'Cactaceae',
            'Rosaceae',
            'Lamiaceae',
            'Asteraceae',
            'Fabaceae',
            'Liliaceae',
            'Orchidaceae',
            'Euphorbiaceae',
            'Moraceae',
            'Rutaceae',
            'Apocynaceae',
            'Arecaceae',
            'Bromeliaceae',
            'Myrtaceae',
        ];

        foreach ($families as $family) {
            DB::table('plant_families')->insert([
                'name'       => $family,
                'slug'       => Str::slug($family),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
