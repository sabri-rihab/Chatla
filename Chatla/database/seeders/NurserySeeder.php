<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\City; // <-- Added this so we can fetch the City IDs

class NurserySeeder extends Seeder
{
    public function run(): void
    {
        // nursery_owner user IDs: 2 through 11 (inserted after admin=1)
        $nurseries = [
            [
                'owner_id'        => 2,  // Youssef El Mansouri
                'name'            => 'Rozana Garden',
                'phone'           => '+212 524-123456',
                'city'            => 'Marrakech',
                'address'         => 'Route de l\'Ourika Km 8, Marrakech',
                'status'          => 'active',
                'website'         => 'https://rozana-garden.ma',
                'rating'          => 5,
                'operating_hours' => 'Mon-Sat: 09:00 AM - 06:00 PM',
            ],
            [
                'owner_id'        => 3,  // Fatima Zahra Benali
                'name'            => 'Fleurs du Rif',
                'phone'           => '+212 539-881122',
                'city'            => 'Chefchaouen',
                'address'         => 'Rue Sidi Abbdallah Guennoun, Chefchaouen',
                'status'          => 'active',
                'website'         => null,
                'rating'          => 4,
                'operating_hours' => 'Mon-Sun: 08:00 AM - 07:00 PM',
            ],
            [
                'owner_id'        => 4,  // Ahmed Tazi
                'name'            => 'Oasis Verte',
                'phone'           => '+212 528-845566',
                'city'            => 'Agadir',
                'address'         => 'Boulevard Mohammed V, Agadir',
                'status'          => 'active',
                'website'         => 'https://oasisverte.ma',
                'rating'          => 4,
                'operating_hours' => 'Mon-Sat: 08:00 AM - 08:00 PM',
            ],
            [
                'owner_id'        => 5,  // Khadija Amrani
                'name'            => 'Jardin Andalous',
                'phone'           => '+212 535-642233',
                'city'            => 'Fès',
                'address'         => 'Route de Sefrou, Fès',
                'status'          => 'active',
                'website'         => null,
                'rating'          => 5,
                'operating_hours' => 'Tue-Sun: 09:00 AM - 05:30 PM',
            ],
            [
                'owner_id'        => 6,  // Rachid Oubella
                'name'            => 'Vert Atlas',
                'phone'           => '+212 523-431188',
                'city'            => 'Beni Mellal',
                'address'         => 'Hay Al Houda, Beni Mellal',
                'status'          => 'active',
                'website'         => null,
                'rating'          => 3,
                'operating_hours' => 'Mon-Fri: 08:30 AM - 06:00 PM',
            ],
            [
                'owner_id'        => 7,  // Nadia Chraibi
                'name'            => 'Bourgeons de Casablanca',
                'phone'           => '+212 522-789900',
                'city'            => 'Casablanca',
                'address'         => 'Bd Zerktouni, Maarif, Casablanca',
                'status'          => 'active',
                'website'         => 'https://bourgeons-casa.ma',
                'rating'          => 4,
                'operating_hours' => 'Mon-Sun: 09:00 AM - 09:00 PM',
            ],
            [
                'owner_id'        => 8,  // Hassan Benyahia
                'name'            => 'Palmeraie Draa',
                'phone'           => '+212 524-989900',
                'city'            => 'Ouarzazate',
                'address'         => 'Route de Zagora Km 5, Ouarzazate',
                'status'          => 'active',
                'website'         => null,
                'rating'          => 5,
                'operating_hours' => 'Mon-Sat: 07:30 AM - 06:00 PM',
            ],
            [
                'owner_id'        => 9,  // Laila Saadi
                'name'            => 'Roses de M\'Gouna',
                'phone'           => '+212 524-837700',
                'city'            => 'Kelaat M\'Gouna',
                'address'         => 'Centre Kelaat M\'Gouna, Province de Tinghir',
                'status'          => 'active',
                'website'         => 'https://roses-mgouna.ma',
                'rating'          => 5,
                'operating_hours' => 'Mon-Sat: 08:00 AM - 06:00 PM',
            ],
            [
                'owner_id'        => 10, // Mustapha Elhilali
                'name'            => 'Jardins du Bouregreg',
                'phone'           => '+212 537-229911',
                'city'            => 'Rabat',
                'address'         => 'Avenue Hassan II, Agdal, Rabat',
                'status'          => 'active',
                'website'         => null,
                'rating'          => 4,
                'operating_hours' => 'Mon-Sat: 09:00 AM - 07:00 PM',
            ],
            [
                'owner_id'        => 11, // Soukaina Derouich
                'name'            => 'Cactus du Souss',
                'phone'           => '+212 528-221100',
                'city'            => 'Taroudant',
                'address'         => 'Route Nationale 10, Taroudant',
                'status'          => 'pending',
                'website'         => null,
                'rating'          => 0,
                'operating_hours' => 'Mon-Sat: 08:00 AM - 06:00 PM',
            ],
        ];

        foreach ($nurseries as $nursery) {
            
            // 1. Find the city ID dynamically (or create it if it doesn't exist yet)
            $city = City::firstOrCreate(['name' => $nursery['city']]);

            // 2. Insert into the database using 'city_id' instead of 'city'
            DB::table('nurseries')->insert([
                'owner_id'        => $nursery['owner_id'],
                'city_id'         => $city->id,  // <-- This is the crucial fix!
                'name'            => $nursery['name'],
                'phone'           => $nursery['phone'],
                'address'         => $nursery['address'],
                'status'          => $nursery['status'],
                'website'         => $nursery['website'],
                'rating'          => $nursery['rating'],
                'operating_hours' => $nursery['operating_hours'],
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }
    }
}