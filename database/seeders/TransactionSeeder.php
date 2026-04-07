<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $appointments = DB::table('appointments')->get();

        foreach ($appointments as $app) {
            DB::table('transactions')->insert([
                'id' => Str::uuid(),
                'appointment_id' => $app->id,
                'amount' => ($app->doctor_id == DB::table('users')->where('email', 'budi@vitaguard.com')->value('id')) ? 200000 : 150000,
                'payment_method' => 'qris',
                'payment_status' => ($app->status == 'completed' || $app->status == 'confirmed') ? 'settlement' : 'pending',
                'paid_at' => ($app->status == 'completed' || $app->status == 'confirmed') ? now() : null,
                'created_at' => $app->created_at,
                'updated_at' => now(),
            ]);
        }
    }
}
