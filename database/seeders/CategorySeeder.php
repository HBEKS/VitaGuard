<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. CATEGORY SERVICE UMUM (5 data tetap)
        $generalCategories = [
            'General Consultation',
            'Specialist Consultation',
            'Medical Checkup',
            'Laboratory Test',
            'Telemedicine',
        ];

        $imageCounter = 1;

        foreach ($generalCategories as $category) {
            DB::table('categories')->insert([
                'category_name' => $category,
                'image' => 'img/categories/' . $imageCounter . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $imageCounter++;
        }

        // 2. CATEGORY SERVICE ONLINE dari SPESIALISASI DOKTER
        $specializations = [
            ['name' => 'Dokter Umum', 'online_service' => 'Konsultasi Umum Online'],
            ['name' => 'Sp. Anak', 'online_service' => 'Konsultasi Anak Online'],
            ['name' => 'Sp. Penyakit Dalam', 'online_service' => 'Konsultasi Penyakit Dalam Online'],
            ['name' => 'Sp. Kandungan & Kebidanan', 'online_service' => 'Konsultasi Kandungan Online'],
            ['name' => 'Sp. Jantung & Pembuluh Darah', 'online_service' => 'Konsultasi Jantung Online'],
            ['name' => 'Sp. Bedah Umum', 'online_service' => 'Konsultasi Bedah Online'],
            ['name' => 'Sp. Mata', 'online_service' => 'Konsultasi Mata Online'],
            ['name' => 'Sp. Saraf', 'online_service' => 'Konsultasi Saraf Online'],
            ['name' => 'Sp. THT-KL', 'online_service' => 'Konsultasi THT Online'],
            ['name' => 'Sp. Kulit & Kelamin', 'online_service' => 'Konsultasi Kulit & Kelamin Online'],
            ['name' => 'Sp. Kejiwaan', 'online_service' => 'Konsultasi Psikiatri Online'],
            ['name' => 'Sp. Gizi Klinik', 'online_service' => 'Konsultasi Gizi Online'],
        ];

        foreach ($specializations as $spec) {
            DB::table('categories')->insert([
                'category_name' => $spec['online_service'],
                'image' => 'img/categories/' . $imageCounter . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $imageCounter++;
        }
    }
}
