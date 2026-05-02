<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $members = DB::table('users')->where('role', 'member')->get();
        $doctors = DB::table('users')->where('role', 'doctor')->get();

        if ($members->isEmpty() || $doctors->isEmpty()) {
            $this->command->warn('User dengan role member/doctor tidak ditemukan.');
            return;
        }

        // Ambil semua service dari database
        $services = DB::table('services')->get();

        // Data dummy appointment dengan service_name
        $appointmentTemplates = [
            [
                'appointment_date' => '2026-04-13',
                'appointment_time' => '09:00:00',
                'consultation_fee' => 100000,
                'status' => 'completed',
                'member_complaint' => 'Masalah berat badan pasca lebaran, susah turun meski sudah olahraga.',
                'doctor_notes' => 'Disarankan defisit kalori 500kcal/hari dan jalan kaki 30 menit.',
                'service_name' => 'Konsultasi Gizi Online - Basic', // Pastikan nama ini ada di DB
            ],
            [
                'appointment_date' => '2026-04-15',
                'appointment_time' => '17:30:00',
                'consultation_fee' => 350000,
                'status' => 'pending',
                'member_complaint' => 'Mau tanya mengenai diet keto, apakah aman untuk jangka panjang?',
                'doctor_notes' => null,
                'service_name' => 'Konsultasi Gizi Online - Premium', // Pastikan nama ini ada di DB
            ],
            [
                'appointment_date' => '2026-04-14',
                'appointment_time' => '14:00:00',
                'consultation_fee' => 140000,
                'status' => 'confirmed',
                'member_complaint' => 'Pemeriksaan rutin mata, minus kanan terasa bertambah.',
                'doctor_notes' => null,
                'service_name' => 'Konsultasi Mata Online', // Pastikan nama ini ada di DB
            ],
        ];

        foreach ($appointmentTemplates as $template) {
            // Cari service_id berdasarkan nama
            $service = $services->where('service_name', $template['service_name'])->first();

            if (!$service) {
                $this->command->warn("Service '{$template['service_name']}' tidak ditemukan, skip appointment ini.");
                continue;
            }

            // Cari doctor yang memiliki service tersebut
            $doctorWithService = DB::table('doctor_profiles as dp')
                ->join('doctor_service as ds', 'dp.id', '=', 'ds.doctor_profile_id')
                ->join('users as u', 'dp.user_id', '=', 'u.id')
                ->where('ds.service_id', $service->id)
                ->select('u.id as doctor_id')
                ->first();

            // Jika tidak ada dokter yang punya service, pilih dokter random
            $doctorId = $doctorWithService ? $doctorWithService->doctor_id : $doctors->random()->id;

            DB::table('appointments')->insert([
                'doctor_id' => $doctorId,
                'member_id' => $members->random()->id,
                'service_id' => $service->id,
                'appointment_date' => $template['appointment_date'],
                'appointment_time' => $template['appointment_time'],
                'consultation_fee' => $template['consultation_fee'],
                'status' => $template['status'],
                'member_complaint' => $template['member_complaint'],
                'doctor_notes' => $template['doctor_notes'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('AppointmentSeeder selesai dijalankan!');
    }
}
