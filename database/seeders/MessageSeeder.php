<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{

    public function run(): void
    {
        $appointments = DB::table('appointments')->get();

        foreach ($appointments as $app) {

            if ($app->status == 'completed') {

                $this->insertChat($app->id, $app->member_id, 'Halo Dokter, selamat pagi. Saya ingin berkonsultasi.');
                $this->insertChat($app->id, $app->doctor_id, 'Selamat pagi. Silakan jelaskan keluhan yang Anda rasakan.');
                $this->insertChat($app->id, $app->member_id, 'Saya merasa sering pusing dan mual setelah makan makanan yang terlalu pedas.');
                $this->insertChat($app->id, $app->doctor_id, 'Dari gejalanya, itu indikasi asam lambung. Saya sarankan istirahat dan kurangi pedas ya.');
                $this->insertChat($app->id, $app->member_id, 'Baik Dokter, terima kasih banyak atas sarannya.');
            } elseif ($app->status == 'confirmed') {

                $this->insertChat($app->id, $app->member_id, 'Halo Dok, saya sudah masuk di ruang chat sesuai jadwal.');
                $this->insertChat($app->id, $app->doctor_id, 'Halo, selamat siang. Iya, ada yang bisa saya bantu terkait keluhan Anda?');
                $this->insertChat($app->id, $app->member_id, 'Mata saya terasa perih dan merah sejak tadi pagi Dok.');
            } elseif ($app->status == 'pending') {
                $this->insertChat($app->id, $app->member_id, 'Selamat siang Dokter, apakah sesi konsultasi saya sudah bisa dimulai?');
            }
        }
    }

    private function insertChat($appointmentId, $senderId, $message)
    {
        DB::table('messages')->insert([
            'appointment_id' => $appointmentId,
            'sender_id' => $senderId,
            'message' => $message,
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
    }
}
