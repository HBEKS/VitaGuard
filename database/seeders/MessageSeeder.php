<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // 1. Ambil semua data janji temu (appointments) yang sudah dibuat oleh AppointmentSeeder
        // Kita butuh data ini untuk tahu siapa Dokter dan Pasien di setiap 'Ruang Chat'
        $appointments = DB::table('appointments')->get();

        foreach ($appointments as $app) {

            /**
             * LOGIKA SKENARIO CHAT:
             * Kita menggunakan $app->status (dari tabel appointments) untuk menentukan
             * seberapa banyak pesan yang sudah dikirim di dalam ruangan tersebut.
             */

            if ($app->status == 'completed') {
                // SKENARIO 1: Konsultasi Selesai
                // Simulasi percakapan lengkap dari awal sampai pemberian solusi
                $this->insertChat($app->id, $app->member_id, 'Halo Dokter, selamat pagi. Saya ingin berkonsultasi.');
                $this->insertChat($app->id, $app->doctor_id, 'Selamat pagi. Silakan jelaskan keluhan yang Anda rasakan.');
                $this->insertChat($app->id, $app->member_id, 'Saya merasa sering pusing dan mual setelah makan makanan yang terlalu pedas.');
                $this->insertChat($app->id, $app->doctor_id, 'Dari gejalanya, itu indikasi asam lambung. Saya sarankan istirahat dan kurangi pedas ya.');
                $this->insertChat($app->id, $app->member_id, 'Baik Dokter, terima kasih banyak atas sarannya.');

            } elseif ($app->status == 'confirmed') {
                // SKENARIO 2: Konsultasi Sedang Berlangsung
                // Simulasi percakapan yang baru saja dimulai
                $this->insertChat($app->id, $app->member_id, 'Halo Dok, saya sudah masuk di ruang chat sesuai jadwal.');
                $this->insertChat($app->id, $app->doctor_id, 'Halo, selamat siang. Iya, ada yang bisa saya bantu terkait keluhan Anda?');
                $this->insertChat($app->id, $app->member_id, 'Mata saya terasa perih dan merah sejak tadi pagi Dok.');

            } elseif ($app->status == 'pending') {
                // SKENARIO 3: Baru Menunggu Antrean
                // Simulasi pasien mengirim sapaan awal tapi belum dibalas dokter
                $this->insertChat($app->id, $app->member_id, 'Selamat siang Dokter, apakah sesi konsultasi saya sudah bisa dimulai?');
            }
        }
    }

    /**
     * Helper Function: Menyisipkan pesan ke tabel messages.
     * Fungsi ini membantu menjaga kode di atas tetap bersih (Clean Code).
     */
    private function insertChat($appointmentId, $senderId, $message)
    {
        DB::table('messages')->insert([
            'appointment_id' => $appointmentId, // Menentukan pesan ini masuk ke 'Ruang Chat' mana
            'sender_id'      => $senderId,      // Menentukan siapa pengirimnya (Member/Doctor)
            'message'        => $message,       // Isi pesan teks
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }
}
