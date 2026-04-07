<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar spesialisasi standar rumah sakit besar (Hospital Grade)
        $specializations = [
            ['name' => 'Dokter Umum', 'category' => 'General'],
            ['name' => 'Sp. Anak', 'category' => 'Pediatrics'],
            ['name' => 'Sp. Penyakit Dalam', 'category' => 'Internal Medicine'],
            ['name' => 'Sp. Kandungan & Kebidanan', 'category' => 'Obstetrics & Gynecology'],
            ['name' => 'Sp. Jantung & Pembuluh Darah', 'category' => 'Cardiology'],
            ['name' => 'Sp. Bedah Umum', 'category' => 'Surgery'],
            ['name' => 'Sp. Mata', 'category' => 'Ophthalmology'],
            ['name' => 'Sp. Saraf', 'category' => 'Neurology'],
            ['name' => 'Sp. THT-KL', 'category' => 'Otolaryngology'],
            ['name' => 'Sp. Kulit & Kelamin', 'category' => 'Dermatology'],
            ['name' => 'Sp. Kejiwaan', 'category' => 'Psychiatry'],
            ['name' => 'Sp. Gizi Klinik', 'category' => 'Nutrition'],
        ];

        foreach ($specializations as $spec) {
            DB::table('specializations')->insert([
                'name' => $spec['name'],
                'slug' => Str::slug($spec['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
