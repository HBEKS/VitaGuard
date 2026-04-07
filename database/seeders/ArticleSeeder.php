<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{

    public function run(): void
    {
        // Cari ID Admin untuk dijadikan penulis artikel
        $admin = DB::table('users')->where('role', 'admin')->first();

        // Jika tidak ada admin, beri pesan error
        if (!$admin) {
            $this->command->error('Admin tidak ditemukan! Buat UserSeeder terlebih dahulu.');
            return;
        }

        // Daftar Artikel Realistis (Standar Aplikasi Kesehatan)
        $articles = [
            [
                'title' => 'Memahami Indeks Massa Tubuh (BMI) dan Panduan Gizi Seimbang',
                'content' => 'Indeks Massa Tubuh (BMI) adalah indikator sederhana yang sering digunakan untuk mengklasifikasikan kelebihan berat badan dan obesitas pada orang dewasa. Mengetahui angka BMI Anda adalah langkah awal yang sangat krusial dalam merencanakan gaya hidup sehat. Namun, BMI bukanlah satu-satunya patokan.

Selain memantau BMI, menjaga asupan kalori harian yang masuk ke dalam tubuh juga sama pentingnya. Konsumsi makanan yang kaya akan serat, protein tanpa lemak, serta vitamin dapat membantu menstabilkan berat badan ideal. Pastikan Anda juga mengimbanginya dengan aktivitas fisik minimal 30 menit sehari.',
            ],
            [
                'title' => 'Miopia Tinggi: Risiko dan Cara Menjaga Kesehatan Mata',
                'content' => 'Miopia tinggi, atau rabun jauh dengan ukuran lensa minus yang besar, memerlukan perhatian medis yang lebih serius dibandingkan miopia ringan. Kondisi ini tidak hanya membuat penderita kesulitan melihat jarak jauh tanpa kacamata yang tebal, tetapi juga meningkatkan risiko komplikasi pada retina mata.

Pemeriksaan rutin ke dokter spesialis mata sangat dianjurkan untuk memantau kondisi mata Anda. Penggunaan lensa kontak atau kacamata dengan indeks bias tinggi dapat membantu kenyamanan aktivitas sehari-hari. Selain itu, mengistirahatkan mata secara berkala saat bekerja di depan layar komputer juga dapat mengurangi ketegangan pada mata.',
            ],
            [
                'title' => 'Terapi Musik: Bagaimana Nada Klasik Membantu Mengelola Stres',
                'content' => 'Kesehatan mental merupakan pilar penting dalam mewujudkan kesejahteraan hidup yang inklusif. Stres akademik atau pekerjaan yang menumpuk seringkali memicu kecemasan. Salah satu metode relaksasi yang terbukti efektif secara klinis adalah mendengarkan musik.

Studi menunjukkan bahwa mendengarkan musik dengan tempo lambat, seperti musik klasik instrumental, dapat menurunkan detak jantung dan tekanan darah. Hal ini membantu otak memasuki fase rileks, sehingga seseorang dapat mengelola suasana hatinya dengan lebih baik dan kembali fokus pada aktivitas sehari-hari.',
            ],
            [
                'title' => 'Pentingnya Jam Tidur yang Cukup untuk Sistem Imun Tubuh',
                'content' => 'Banyak orang mengabaikan pentingnya waktu istirahat di tengah jadwal yang padat. Padahal, tidur yang cukup (7-8 jam per malam) adalah kunci utama bagi sistem kekebalan tubuh untuk melakukan regenerasi sel-sel yang rusak.

Kurang tidur kronis dapat meningkatkan risiko berbagai penyakit metabolisme, termasuk diabetes dan penyakit jantung. Oleh karena itu, membangun rutinitas tidur yang konsisten setiap malam adalah investasi kesehatan jangka panjang yang tidak boleh diremehkan.',
            ],
            [
                'title' => 'Konsultasi Dokter Online: Masa Depan Layanan Kesehatan Inklusif',
                'content' => 'Perkembangan teknologi telah membawa transformasi besar dalam industri kesehatan. Layanan konsultasi dokter secara online, atau telemedicine, kini menjadi solusi utama untuk menjembatani akses kesehatan bagi masyarakat luas tanpa terbatas jarak.

Platform digital memungkinkan pasien untuk mendapatkan diagnosis awal dan resep obat tanpa harus membuang waktu antre di klinik. Ini adalah wujud nyata dari pelayanan kesehatan yang merata dan mudah dijangkau oleh semua lapisan masyarakat.',
            ]
        ];

        // Masukkan data ke database
        foreach ($articles as $article) {
            DB::table('articles')->insert([
                'author_id' => $admin->id,
                'title' => $article['title'],
                'slug' => Str::slug($article['title']) . '-' . Str::random(5),
                'content' => $article['content'],
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
