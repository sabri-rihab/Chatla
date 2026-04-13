<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Seed all Moroccan cities (prefectures and major urban centres).
     */
    public function run(): void
    {
        $cities = [
            // Grand Casablanca-Settat
            'Casablanca',
            'Mohammedia',
            'El Jadida',
            'Settat',
            'Berrechid',
            'Benslimane',
            'Khouribga',

            // Rabat-Salé-Kénitra
            'Rabat',
            'Salé',
            'Témara',
            'Kénitra',
            'Skhirat',
            'Sidi Kacem',
            'Sidi Slimane',

            // Marrakech-Safi
            'Marrakech',
            'Safi',
            'Essaouira',
            'Kelaat Sraghna',
            'Chichaoua',
            'Al Haouz',
            'Rehamna',

            // Fès-Meknès
            'Fès',
            'Meknès',
            'Ifrane',
            'Sefrou',
            'Moulay Yacoub',
            'El Hajeb',
            'Boulemane',
            'Taounate',
            'Taza',

            // Tanger-Tétouan-Al Hoceima
            'Tanger',
            'Tétouan',
            'Al Hoceima',
            'Chefchaouen',
            'Larache',
            'Fahs-Anjra',
            'M\'diq-Fnideq',
            'Ouezzane',

            // Oriental
            'Oujda',
            'Nador',
            'Berkane',
            'Taourirt',
            'Jerada',
            'Figuig',
            'Driouch',
            'Guercif',

            // Souss-Massa
            'Agadir',
            'Inezgane-Aït Melloul',
            'Taroudant',
            'Tiznit',
            'Chtouka-Aït Baha',
            'Tata',

            // Drâa-Tafilalet
            'Ouarzazate',
            'Errachidia',
            'Zagora',
            'Midelt',
            'Tinghir',

            // Béni Mellal-Khénifra
            'Beni Mellal',
            'Khénifra',
            'Azilal',
            'Fquih Ben Salah',
            'Khouribga',

            // Guelmim-Oued Noun
            'Guelmim',
            'Sidi Ifni',
            'Tan-Tan',
            'Assa-Zag',

            // Laâyoune-Sakia El Hamra
            'Laâyoune',
            'Boujdour',
            'Tarfaya',
            'Es Semara',

            // Dakhla-Oued Ed-Dahab
            'Dakhla',
            'Aousserd',

            // Other notable cities
            'Nador',
            'Oued Zem',
            'Ksar El Kebir',
            'Sidi Bennour',
            'Youssoufia',
            'Khémisset',
            'Kelaat M\'Gouna',
            'Erfoud',
            'Rissani',
            'Azrou',
            'Bouznika',
            'Ain El Aouda',
        ];

        // Deduplicate and insert
        $unique = array_values(array_unique($cities));

        foreach ($unique as $name) {
            City::firstOrCreate(['name' => $name]);
        }
    }
}
