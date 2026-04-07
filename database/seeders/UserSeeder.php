<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents; // Hanya import di sini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------
        // 1. Akun Admin (Sesuai Permintaan)
        // ---------------------------------------------------------
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'name' => 'admin',
            'email' => 'admin@vitaguard.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // ---------------------------------------------------------
        // 2. Data Dokter Nyata & Password Unik
        // ---------------------------------------------------------
        $doctors = [
            ['name' => 'dr. Andi Pratama', 'email' => 'andi@vitaguard.com', 'password' => 'AndiGizi2026', 'spec' => 'Sp. Gizi Klinik'],
            ['name' => 'dr. Budi Santoso', 'email' => 'budi@vitaguard.com', 'password' => 'BudiMata2026', 'spec' => 'Sp. Mata'],
            ['name' => 'dr. Citra Kirana', 'email' => 'citra@vitaguard.com', 'password' => 'CitraJiwa2026', 'spec' => 'Sp. Kejiwaan'],
            ['name' => 'dr. Diana Putri', 'email' => 'diana@vitaguard.com', 'password' => 'DianaDalam2026', 'spec' => 'Sp. Penyakit Dalam'],
            ['name' => 'dr. Eka Wijaya', 'email' => 'eka@vitaguard.com', 'password' => 'EkaUmum2026', 'spec' => 'Dokter Umum'],
        ];

        foreach ($doctors as $doc) {
            $doctorId = Str::uuid();
            $specId = DB::table('specializations')->where('name', $doc['spec'])->value('id');

            // Insert User Dokter
            DB::table('users')->insert([
                'id' => $doctorId,
                'name' => $doc['name'],
                'email' => $doc['email'],
                'password' => Hash::make($doc['password']),
                'role' => 'doctor',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Insert Profil Dokter
            DB::table('doctor_profiles')->insert([
                'user_id' => $doctorId,
                'specialization_id' => $specId,
                'experience_years' => rand(10, 30),
                'str_number' => 'STR-'.rand(1000000000, 9999999999),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // ---------------------------------------------------------
        // 3. Data Member Nyata & Password Unik
        // ---------------------------------------------------------
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

        foreach ($members as $member) {
            DB::table('users')->insert([
                'id' => Str::uuid(),
                'name' => $member['name'],
                'email' => $member['email'],
                'password' => Hash::make($member['password']),
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
