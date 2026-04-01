<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        DB::table('users')->insert([
            'name'              => 'Admin Chatla',
            'email'             => 'admin@chatla.ma',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
            'profile_img'       => null,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        // 10 Nursery Owners
        $nurseryOwners = [
            ['name' => 'Youssef El Mansouri',    'email' => 'youssef.mansouri@chatla.ma'],
            ['name' => 'Fatima Zahra Benali',     'email' => 'fatima.benali@chatla.ma'],
            ['name' => 'Ahmed Tazi',              'email' => 'ahmed.tazi@chatla.ma'],
            ['name' => 'Khadija Amrani',          'email' => 'khadija.amrani@chatla.ma'],
            ['name' => 'Rachid Oubella',          'email' => 'rachid.oubella@chatla.ma'],
            ['name' => 'Nadia Chraibi',           'email' => 'nadia.chraibi@chatla.ma'],
            ['name' => 'Hassan Benyahia',         'email' => 'hassan.benyahia@chatla.ma'],
            ['name' => 'Laila Saadi',             'email' => 'laila.saadi@chatla.ma'],
            ['name' => 'Mustapha Elhilali',       'email' => 'mustapha.elhilali@chatla.ma'],
            ['name' => 'Soukaina Derouich',       'email' => 'soukaina.derouich@chatla.ma'],
        ];

        foreach ($nurseryOwners as $owner) {
            DB::table('users')->insert([
                'name'              => $owner['name'],
                'email'             => $owner['email'],
                'password'          => Hash::make('password'),
                'role'              => 'nursery_owner',
                'email_verified_at' => now(),
                'profile_img'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        // 20 Simple Users
        $simpleUsers = [
            ['name' => 'Imane Benkirane',      'email' => 'imane.benkirane@chatla.ma'],
            ['name' => 'Karim Filali',         'email' => 'karim.filali@chatla.ma'],
            ['name' => 'Zineb Hajji',          'email' => 'zineb.hajji@chatla.ma'],
            ['name' => 'Omar Ouadghiri',       'email' => 'omar.ouadghiri@chatla.ma'],
            ['name' => 'Meryem Berrada',       'email' => 'meryem.berrada@chatla.ma'],
            ['name' => 'Abdelilah Moussaoui',  'email' => 'abdelilah.moussaoui@chatla.ma'],
            ['name' => 'Salma Tahiri',         'email' => 'salma.tahiri@chatla.ma'],
            ['name' => 'Hamza Ziani',          'email' => 'hamza.ziani@chatla.ma'],
            ['name' => 'Ghita Benjelloun',     'email' => 'ghita.benjelloun@chatla.ma'],
            ['name' => 'Anas Bekkali',         'email' => 'anas.bekkali@chatla.ma'],
            ['name' => 'Sara El Ouafi',        'email' => 'sara.elouafi@chatla.ma'],
            ['name' => 'Tariq Essabri',        'email' => 'tariq.essabri@chatla.ma'],
            ['name' => 'Houda Lahlou',         'email' => 'houda.lahlou@chatla.ma'],
            ['name' => 'Mehdi Cherkaoui',      'email' => 'mehdi.cherkaoui@chatla.ma'],
            ['name' => 'Nour Eddine Fassi',    'email' => 'noureddine.fassi@chatla.ma'],
            ['name' => 'Ikram Alami',          'email' => 'ikram.alami@chatla.ma'],
            ['name' => 'Yassine Bouyahia',     'email' => 'yassine.bouyahia@chatla.ma'],
            ['name' => 'Rim Kettani',          'email' => 'rim.kettani@chatla.ma'],
            ['name' => 'Bilal Naciri',         'email' => 'bilal.naciri@chatla.ma'],
            ['name' => 'Asmaa El Khamlichi',   'email' => 'asmaa.elkhamlichi@chatla.ma'],
        ];

        foreach ($simpleUsers as $user) {
            DB::table('users')->insert([
                'name'              => $user['name'],
                'email'             => $user['email'],
                'password'          => Hash::make('password'),
                'role'              => 'simple',
                'email_verified_at' => now(),
                'profile_img'       => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }
}
