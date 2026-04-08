<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $members = DB::table('users')->where('role', 'member')->get();
        $doctors = DB::table('users')->where('role', 'doctor')->get();

        if ($members->isEmpty() || $doctors->isEmpty()) {
            $this->command?->warn('User dengan role member/doctor tidak ditemukan.');
            return;
        }

        // Data dummy appointment (tanpa doctor_id dan member_id)
        $appointmentTemplates = [
            [
                'appointment_date' => '2026-04-13',
                'appointment_time' => '09:00:00',
                'consultation_fee' => 150000.00,
                'status' => 'completed',
                'member_complaint' => 'Masalah berat badan pasca lebaran, susah turun meski sudah olahraga.',
                'doctor_notes' => 'Disarankan defisit kalori 500kcal/hari dan jalan kaki 30 menit.',
            ],
            [
                'appointment_date' => '2026-04-15',
                'appointment_time' => '17:30:00',
                'consultation_fee' => 150000.00,
                'status' => 'pending',
                'member_complaint' => 'Mau tanya mengenai diet keto, apakah aman untuk jangka panjang?',
                'doctor_notes' => null,
            ],
            [
                'appointment_date' => '2026-04-14',
                'appointment_time' => '14:00:00',
                'consultation_fee' => 200000.00,
                'status' => 'confirmed',
                'member_complaint' => 'Pemeriksaan rutin mata, minus kanan terasa bertambah.',
                'doctor_notes' => null,
            ],
        ];

        // Assign random doctor & member untuk setiap appointment
        foreach ($appointmentTemplates as $template) {
            DB::table('appointments')->insert(array_merge($template, [
                'id' => Str::uuid(),
                'doctor_id' => $doctors->random()->id,  // ✅ Random dokter
                'member_id' => $members->random()->id,  // ✅ Random member
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
