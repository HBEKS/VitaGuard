<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Mapping: doctor_profile_id -> array of service_id (berdasarkan data di database)
        $relations = [
            // dr. Andi Pratama (id=1) - Sp. Gizi Klinik
            1 => [
                34, // Konsultasi Gizi Online - Basic
                35, // Konsultasi Gizi Online - Premium (jika ada, dari gambar id 34 basic)
                10, // Medical Checkup Premium (id=10)
                18, // Chat Dokter (id=18)
            ],

            // dr. Budi Santoso (id=2) - Sp. Mata
            2 => [
                29, // Konsultasi Mata Online (id=29)
                9,  // Medical Checkup Basic (id=9)
                17, // Telekonsultasi 30 Menit (id=17)
                18, // Chat Dokter (id=18)
            ],

            // dr. Citra Kirana (id=3) - Sp. Kejiwaan
            3 => [
                33, // Konsultasi Psikiatri Online (id=33)
                2,  // Konsultasi Dokter Umum (id=2)
                17, // Telekonsultasi 30 Menit (id=17)
                18, // Chat Dokter (id=18)
            ],

            // dr. Diana Putri (id=4) - Sp. Penyakit Dalam
            4 => [
                24, // Konsultasi Penyakit Dalam Online (id=24)
                10, // Medical Checkup Premium (id=10)
                12, // Cek Darah Lengkap (id=12)
                14, // Cek Kolesterol (id=14)
            ],

            // dr. Eka Wijaya (id=5) - Dokter Umum
            5 => [
                2,  // Konsultasi Dokter Umum (id=2)
                3,  // Home Visit Dokter Umum (id=3)
                20, // Konsultasi Umum Online - Basic (id=20)
                17, // Telekonsultasi 30 Menit (id=17)
            ],
        ];

        // Hapus data lama
        DB::table('doctor_service')->truncate();

        // Insert data baru
        foreach ($relations as $doctorId => $serviceIds) {
            foreach ($serviceIds as $serviceId) {
                // Cek apakah service_id benar-benar ada di database
                $exists = DB::table('services')->where('id', $serviceId)->exists();

                if ($exists) {
                    DB::table('doctor_service')->insert([
                        'doctor_profile_id' => $doctorId,
                        'service_id' => $serviceId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $this->command->warn("Service ID {$serviceId} tidak ditemukan untuk dokter ID {$doctorId}");
                }
            }
        }

        $this->command->info('DoctorServiceSeeder berhasil dijalankan!');
    }
}
