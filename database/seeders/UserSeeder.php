<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@vitaguard.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'avatar' => 'img/profiles/admin.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $doctors = [
            ['name' => 'dr. Andi Pratama', 'email' => 'andi@vitaguard.com', 'password' => 'AndiGizi2026', 'spec' => 'Sp. Gizi Klinik'],
            ['name' => 'dr. Budi Santoso', 'email' => 'budi@vitaguard.com', 'password' => 'BudiMata2026', 'spec' => 'Sp. Mata'],
            ['name' => 'dr. Citra Kirana', 'email' => 'citra@vitaguard.com', 'password' => 'CitraJiwa2026', 'spec' => 'Sp. Kejiwaan'],
            ['name' => 'dr. Diana Putri', 'email' => 'diana@vitaguard.com', 'password' => 'DianaDalam2026', 'spec' => 'Sp. Penyakit Dalam'],
            ['name' => 'dr. Eka Wijaya', 'email' => 'eka@vitaguard.com', 'password' => 'EkaUmum2026', 'spec' => 'Dokter Umum'],
        ];


        $doctorPictureCounter = 1;

        foreach ($doctors as $doc) {
            // Insert user dulu dengan avatar
            $userId = DB::table('users')->insertGetId([
                'name' => $doc['name'],
                'email' => $doc['email'],
                'password' => Hash::make($doc['password']),
                'role' => 'doctor',
                'avatar' => 'img/profiles/doctor' . $doctorPictureCounter . '.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Ambil specialization_id
            $specId = DB::table('specializations')->where('name', $doc['spec'])->value('id');

            // Insert doctor_profile dengan user_id
            DB::table('doctor_profiles')->insert([
                'user_id' => $userId,
                'specialization_id' => $specId,
                'experience_years' => rand(1, 15),
                'str_number' => 'STR-' . rand(1000000000, 9999999999),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $doctorPictureCounter++; // Increment ke 2, 3, 4, 5
        }

        $members = [
            ['name' => 'Ahmad Faisal', 'email' => 'ahmad@mail.com', 'password' => 'AhmadPass01'],
            ['name' => 'Bunga Citra', 'email' => 'bunga@mail.com', 'password' => 'BungaPass02'],
            ['name' => 'Candra Wijaya', 'email' => 'candra@mail.com', 'password' => 'CandraPass03'],
            ['name' => 'Dwi Lestari', 'email' => 'dwi@mail.com', 'password' => 'DwiPass04'],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@mail.com', 'password' => 'EkoPass05'],
            ['name' => 'Fitriani', 'email' => 'fitri@mail.com', 'password' => 'FitriPass06'],
            ['name' => 'Galih Purnama', 'email' => 'galih@mail.com', 'password' => 'GalihPass07'],
            ['name' => 'Hendra Gunawan', 'email' => 'hendra@mail.com', 'password' => 'HendraPass08'],
            ['name' => 'Intan Permata', 'email' => 'intan@mail.com', 'password' => 'IntanPass09'],
            ['name' => 'Joko Susilo', 'email' => 'joko@mail.com', 'password' => 'JokoPass10'],
        ];

        $memberPictureCounter = 1;

        foreach ($members as $member) {
            DB::table('users')->insert([
                'name' => $member['name'],
                'email' => $member['email'],
                'password' => Hash::make($member['password']),
                'role' => 'member',
                'avatar' => 'img/profiles/member' . $memberPictureCounter . '.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $memberPictureCounter++;
        }
    }
}
