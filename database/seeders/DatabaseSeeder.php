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
            SpecializationSeeder::class,
            CategorySeeder::class,
            ServiceSeeder::class,
            UserSeeder::class,
            DoctorServiceSeeder::class,
            ArticleSeeder::class,
            ScheduleSeeder::class,
            AppointmentSeeder::class,
            TransactionSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
