<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. DATA MASTER (Paling Dasar, tidak bergantung pada tabel manapun)
            SpecializationSeeder::class,

            // 2. DATA AKUN & PROFIL (Bergantung pada tabel specializations)
            UserSeeder::class,

            // 3. DATA KONTEN (Opsional, bergantung pada tabel users/doctors)
            ArticleSeeder::class,

            // 4. DATA JADWAL (Bergantung pada tabel users/doctors)
            ScheduleSeeder::class,

            // 5. DATA TRANSAKSIONAL (Janji Temu: bergantung pada jadwal, dokter, dan pasien)
            AppointmentSeeder::class,

            // 6. DATA KEUANGAN (Bergantung pada appointment dan profil dokter)
            TransactionSeeder::class,

            // 7. DATA KOMUNIKASI (Bergantung pada appointment dan users)
            MessageSeeder::class,
        ]);
    }
}
