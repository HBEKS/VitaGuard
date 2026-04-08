<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil ID dokter berdasarkan email (Sesuai dengan UserSeeder kita)
        $docAndi = DB::table('users')->where('email', 'andi@vitaguard.com')->first();
        $docBudi = DB::table('users')->where('email', 'budi@vitaguard.com')->first();
        $docCitra = DB::table('users')->where('email', 'citra@vitaguard.com')->first();
        $docDiana = DB::table('users')->where('email', 'diana@vitaguard.com')->first();
        $docEka = DB::table('users')->where('email', 'eka@vitaguard.com')->first();

        // Pencegahan error jika UserSeeder belum dijalankan
        if (!$docAndi || !$docBudi || !$docCitra || !$docDiana || !$docEka) {
            $this->command->error('Data dokter tidak lengkap! Pastikan UserSeeder dijalankan terlebih dahulu.');
            return;
        }

        // 2. Susun Data Jadwal dengan Array (Sangat mudah dibaca dan diubah)
        $schedules = [
            // dr. Andi (Sp. Gizi Klinik) - Aktif semua
            $docAndi->id => [
                ['day' => 'Monday', 'start' => '08:00:00', 'end' => '10:00:00', 'is_active' => true],
                ['day' => 'Wednesday', 'start' => '17:00:00', 'end' => '19:00:00', 'is_active' => true],
            ],

            // dr. Budi (Sp. Mata) - Hari Kamis sengaja dinonaktifkan (Contoh sedang cuti)
            $docBudi->id => [
                ['day' => 'Tuesday', 'start' => '13:00:00', 'end' => '15:00:00', 'is_active' => true],
                ['day' => 'Thursday', 'start' => '13:00:00', 'end' => '15:00:00', 'is_active' => false],
            ],

            // dr. Citra (Sp. Kejiwaan) - Shift panjang di akhir pekan
            $docCitra->id => [
                ['day' => 'Friday', 'start' => '16:00:00', 'end' => '20:00:00', 'is_active' => true],
                ['day' => 'Saturday', 'start' => '09:00:00', 'end' => '14:00:00', 'is_active' => true],
            ],

            // dr. Diana (Sp. Penyakit Dalam) - Praktek 3 hari berturut-turut
            $docDiana->id => [
                ['day' => 'Monday', 'start' => '09:00:00', 'end' => '15:00:00', 'is_active' => true],
                ['day' => 'Tuesday', 'start' => '09:00:00', 'end' => '15:00:00', 'is_active' => true],
                ['day' => 'Wednesday', 'start' => '09:00:00', 'end' => '15:00:00', 'is_active' => true],
            ],

            // dr. Eka (Dokter Umum) - Standby setiap hari kerja pagi
            $docEka->id => [
                ['day' => 'Monday', 'start' => '08:00:00', 'end' => '12:00:00', 'is_active' => true],
                ['day' => 'Tuesday', 'start' => '08:00:00', 'end' => '12:00:00', 'is_active' => true],
                ['day' => 'Wednesday', 'start' => '08:00:00', 'end' => '12:00:00', 'is_active' => true],
                ['day' => 'Thursday', 'start' => '08:00:00', 'end' => '12:00:00', 'is_active' => true],
                ['day' => 'Friday', 'start' => '08:00:00', 'end' => '12:00:00', 'is_active' => true],
            ],
        ];

        // 3. Masukkan ke Database menggunakan looping
        foreach ($schedules as $doctorId => $days) {
            foreach ($days as $schedule) {
                DB::table('schedules')->insert([
                    'doctor_id' => $doctorId,
                    'day_of_week' => $schedule['day'],
                    'start_time' => $schedule['start'],
                    'end_time' => $schedule['end'],
                    'is_active' => $schedule['is_active'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
