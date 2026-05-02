<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            // ==================== CATEGORY ID 1: General Consultation ====================
            [
                'service_name' => 'Konsultasi Dokter Online',
                'description' => 'Layanan konsultasi kesehatan secara online dengan dokter umum untuk membantu menjawab berbagai keluhan kesehatan ringan hingga memberikan saran penanganan awal sebelum melakukan pemeriksaan lebih lanjut di fasilitas kesehatan.',
                'availability' => '08.00 – 21.00',
                'price' => 50000,
                'category_id' => 1,
            ],
            [
                'service_name' => 'Konsultasi Dokter Umum',
                'description' => 'Konsultasi langsung dengan dokter umum di klinik untuk pemeriksaan fisik dan penanganan keluhan kesehatan ringan hingga sedang.',
                'availability' => '08.00 - 20.00',
                'price' => 75000,
                'category_id' => 1,
            ],
            [
                'service_name' => 'Home Visit Dokter Umum',
                'description' => 'Layanan kunjungan dokter umum ke rumah pasien untuk pemeriksaan dan penanganan keluhan kesehatan.',
                'availability' => '09.00 - 17.00',
                'price' => 200000,
                'category_id' => 1,
            ],

            // ==================== CATEGORY ID 2: Specialist Consultation ====================
            [
                'service_name' => 'Konsultasi Dokter Spesialis Anak',
                'description' => 'Konsultasi dengan dokter spesialis anak untuk penanganan masalah kesehatan pada bayi, anak, dan remaja.',
                'availability' => '09.00 - 17.00',
                'price' => 150000,
                'category_id' => 2,
            ],
            [
                'service_name' => 'Konsultasi Dokter Spesialis Jantung',
                'description' => 'Konsultasi dengan dokter spesialis jantung untuk pemeriksaan dan penanganan masalah kardiovaskular.',
                'availability' => '08.00 - 16.00',
                'price' => 200000,
                'category_id' => 2,
            ],
            [
                'service_name' => 'Konsultasi Dokter Spesialis Kandungan',
                'description' => 'Konsultasi dengan dokter spesialis kandungan untuk kesehatan reproduksi wanita, kehamilan, dan persalinan.',
                'availability' => '09.00 - 18.00',
                'price' => 175000,
                'category_id' => 2,
            ],
            [
                'service_name' => 'Konsultasi Dokter Spesialis Saraf',
                'description' => 'Konsultasi dengan dokter spesialis saraf untuk penanganan masalah neurologi seperti sakit kepala, stroke, dan epilepsi.',
                'availability' => '09.00 - 15.00',
                'price' => 225000,
                'category_id' => 2,
            ],
            [
                'service_name' => 'Konsultasi Dokter Spesialis Bedah',
                'description' => 'Konsultasi dengan dokter spesialis bedah untuk evaluasi tindakan operasi dan perawatan pasca operasi.',
                'availability' => '10.00 - 14.00',
                'price' => 250000,
                'category_id' => 2,
            ],

            // ==================== CATEGORY ID 3: Medical Checkup ====================
            [
                'service_name' => 'Medical Checkup Basic',
                'description' => 'Paket pemeriksaan kesehatan dasar meliputi cek fisik, tekanan darah, gula darah, kolesterol, dan asam urat.',
                'availability' => '07.00 - 11.00',
                'price' => 350000,
                'category_id' => 3,
            ],
            [
                'service_name' => 'Medical Checkup Premium',
                'description' => 'Paket pemeriksaan kesehatan lengkap meliputi cek fisik, darah lengkap, urine, rontgen thorax, EKG, dan konsultasi dokter.',
                'availability' => '07.00 - 11.00',
                'price' => 850000,
                'category_id' => 3,
            ],
            [
                'service_name' => 'Medical Checkup Executive',
                'description' => 'Paket pemeriksaan kesehatan komprehensif termasuk USG abdomen, treadmill test, dan konsultasi dengan 3 spesialis.',
                'availability' => '07.00 - 10.00',
                'price' => 1750000,
                'category_id' => 3,
            ],

            // ==================== CATEGORY ID 4: Laboratory Test ====================
            [
                'service_name' => 'Cek Darah Lengkap',
                'description' => 'Pemeriksaan hematologi lengkap untuk mengevaluasi sel darah merah, sel darah putih, hemoglobin, hematokrit, dan trombosit.',
                'availability' => '08.00 - 20.00',
                'price' => 120000,
                'category_id' => 4,
            ],
            [
                'service_name' => 'Cek Gula Darah',
                'description' => 'Pemeriksaan kadar gula darah puasa dan sewaktu untuk mendeteksi diabetes melitus.',
                'availability' => '08.00 - 20.00',
                'price' => 50000,
                'category_id' => 4,
            ],
            [
                'service_name' => 'Cek Kolesterol',
                'description' => 'Pemeriksaan kadar kolesterol total, HDL, LDL, dan trigliserida dalam darah.',
                'availability' => '08.00 - 20.00',
                'price' => 80000,
                'category_id' => 4,
            ],
            [
                'service_name' => 'Cek Fungsi Hati',
                'description' => 'Pemeriksaan enzim hati (SGOT, SGPT) untuk mengevaluasi fungsi organ hati.',
                'availability' => '08.00 - 20.00',
                'price' => 95000,
                'category_id' => 4,
            ],
            [
                'service_name' => 'Cek Fungsi Ginjal',
                'description' => 'Pemeriksaan kadar ureum dan kreatinin untuk mengevaluasi fungsi organ ginjal.',
                'availability' => '08.00 - 20.00',
                'price' => 90000,
                'category_id' => 4,
            ],

            // ==================== CATEGORY ID 5: Telemedicine ====================
            [
                'service_name' => 'Telekonsultasi 30 Menit',
                'description' => 'Layanan konsultasi kesehatan melalui video call selama 30 menit dengan dokter umum untuk berbagai keluhan kesehatan.',
                'availability' => '24 Jam',
                'price' => 100000,
                'category_id' => 5,
            ],
            [
                'service_name' => 'Chat Dokter',
                'description' => 'Layanan konsultasi kesehatan melalui chat teks dengan dokter umum, cocok untuk pertanyaan singkat dan follow up.',
                'availability' => '24 Jam',
                'price' => 35000,
                'category_id' => 5,
            ],
            [
                'service_name' => 'Telekonsultasi Spesialis 45 Menit',
                'description' => 'Layanan konsultasi melalui video call dengan dokter spesialis pilihan selama 45 menit.',
                'availability' => '09.00 - 20.00',
                'price' => 200000,
                'category_id' => 5,
            ],

            // ==================== CATEGORY ID 6: Konsultasi Umum Online ====================
            [
                'service_name' => 'Konsultasi Umum Online - Basic',
                'description' => 'Konsultasi online dengan dokter umum untuk keluhan ringan seperti flu, demam, batuk, pilek, dan sakit kepala.',
                'availability' => '24 Jam',
                'price' => 45000,
                'category_id' => 6,
            ],
            [
                'service_name' => 'Konsultasi Umum Online - Premium',
                'description' => 'Konsultasi online lengkap dengan dokter umum termasuk resep obat dan surat keterangan sakit.',
                'availability' => '24 Jam',
                'price' => 75000,
                'category_id' => 6,
            ],

            // ==================== CATEGORY ID 7: Konsultasi Anak Online ====================
            [
                'service_name' => 'Konsultasi Anak Online - Basic',
                'description' => 'Konsultasi online dengan dokter spesialis anak untuk keluhan seperti demam, batuk, pilek, diare, dan ruam kulit pada anak.',
                'availability' => '08.00 - 22.00',
                'price' => 125000,
                'category_id' => 7,
            ],
            [
                'service_name' => 'Konsultasi Tumbuh Kembang Anak Online',
                'description' => 'Konsultasi online untuk memantau tumbuh kembang anak termasuk perkembangan motorik, bicara, dan sosial anak.',
                'availability' => '09.00 - 17.00',
                'price' => 150000,
                'category_id' => 7,
            ],

            // ==================== CATEGORY ID 8: Konsultasi Penyakit Dalam Online ====================
            [
                'service_name' => 'Konsultasi Penyakit Dalam Online',
                'description' => 'Konsultasi online dengan dokter spesialis penyakit dalam untuk keluhan seperti diabetes, hipertensi, kolesterol, dan asam urat.',
                'availability' => '09.00 - 20.00',
                'price' => 175000,
                'category_id' => 8,
            ],

            // ==================== CATEGORY ID 9: Konsultasi Kandungan Online ====================
            [
                'service_name' => 'Konsultasi Kandungan Online',
                'description' => 'Konsultasi online dengan dokter spesialis kandungan untuk masalah kesehatan reproduksi wanita dan keluarga berencana.',
                'availability' => '09.00 - 21.00',
                'price' => 160000,
                'category_id' => 9,
            ],
            [
                'service_name' => 'Konsultasi Kehamilan Online',
                'description' => 'Konsultasi online untuk ibu hamil meliputi perkembangan janin, keluhan kehamilan, dan persiapan persalinan.',
                'availability' => '10.00 - 18.00',
                'price' => 180000,
                'category_id' => 9,
            ],

            // ==================== CATEGORY ID 10: Konsultasi Jantung Online ====================
            [
                'service_name' => 'Konsultasi Jantung Online',
                'description' => 'Konsultasi online dengan dokter spesialis jantung untuk keluhan nyeri dada, sesak nafas, jantung berdebar, dan hipertensi.',
                'availability' => '08.00 - 16.00',
                'price' => 200000,
                'category_id' => 10,
            ],

            // ==================== CATEGORY ID 11: Konsultasi Bedah Online ====================
            [
                'service_name' => 'Konsultasi Bedah Online',
                'description' => 'Konsultasi online dengan dokter spesialis bedah untuk konsultasi pra operasi dan evaluasi pasca operasi.',
                'availability' => '09.00 - 15.00',
                'price' => 225000,
                'category_id' => 11,
            ],

            // ==================== CATEGORY ID 12: Konsultasi Mata Online ====================
            [
                'service_name' => 'Konsultasi Mata Online',
                'description' => 'Konsultasi online dengan dokter spesialis mata untuk keluhan mata merah, gatal, penglihatan kabur, dan mata kering.',
                'availability' => '10.00 - 19.00',
                'price' => 140000,
                'category_id' => 12,
            ],

            // ==================== CATEGORY ID 13: Konsultasi Saraf Online ====================
            [
                'service_name' => 'Konsultasi Saraf Online',
                'description' => 'Konsultasi online dengan dokter spesialis saraf untuk keluhan sakit kepala kronis, migrain, kesemutan, dan gangguan tidur.',
                'availability' => '09.00 - 17.00',
                'price' => 210000,
                'category_id' => 13,
            ],

            // ==================== CATEGORY ID 14: Konsultasi THT Online ====================
            [
                'service_name' => 'Konsultasi THT Online',
                'description' => 'Konsultasi online dengan dokter spesialis THT untuk keluhan telinga berdengung, sakit tenggorokan, pilek kronis, dan gangguan pendengaran.',
                'availability' => '08.00 - 20.00',
                'price' => 145000,
                'category_id' => 14,
            ],

            // ==================== CATEGORY ID 15: Konsultasi Kulit & Kelamin Online ====================
            [
                'service_name' => 'Konsultasi Kulit Online',
                'description' => 'Konsultasi online dengan dokter spesialis kulit untuk keluhan jerawat, eksim, psoriasis, gatal-gatal, dan penuaan dini.',
                'availability' => '24 Jam',
                'price' => 155000,
                'category_id' => 15,
            ],

            // ==================== CATEGORY ID 16: Konsultasi Psikiatri Online ====================
            [
                'service_name' => 'Konsultasi Psikiatri Online',
                'description' => 'Konsultasi online dengan psikiater untuk masalah kesehatan mental seperti stres berat, depresi, gangguan cemas, dan insomnia.',
                'availability' => '24 Jam (By Appointment)',
                'price' => 250000,
                'category_id' => 16,
            ],

            // ==================== CATEGORY ID 17: Konsultasi Gizi Online ====================
            [
                'service_name' => 'Konsultasi Gizi Online - Basic',
                'description' => 'Konsultasi online dengan ahli gizi untuk konsultasi diet sehat, manajemen berat badan, dan pola makan seimbang.',
                'availability' => '09.00 - 21.00',
                'price' => 100000,
                'category_id' => 17,
            ],
            [
                'service_name' => 'Konsultasi Gizi Online - Premium',
                'description' => 'Paket lengkap konsultasi gizi termasuk rencana diet 30 hari, monitoring mingguan, dan konsultasi unlimited via chat.',
                'availability' => '09.00 - 21.00',
                'price' => 350000,
                'category_id' => 17,
            ],
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                'service_name' => $service['service_name'],
                'description' => $service['description'],
                'availability' => $service['availability'],
                'price' => $service['price'],
                'category_id' => $service['category_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
