<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('image_url');
            $table->text('summary');
            $table->text('content');
            $table->timestamps();
        });

        // Seed artikel default agar halaman edukasi tidak kosong saat migrasi pertama kali
        DB::table('articles')->insert([
            [
                'title' => 'Mengatasi Burnout Kerja',
                'category' => 'Work Life',
                'image_url' => 'https://images.unsplash.com/photo-1758598497429-6eb3895d5bfa?q=80&w=600&auto=format&fit=crop',
                'summary' => 'Merasa lelah terus menerus? Kenali tanda-tanda burnout sebelum terlambat.',
                'content' => '<p>Merasa lelah terus menerus? Itu bukan sekadar capek biasa. Burnout adalah kondisi kelelahan emosional, fisik, dan mental yang disebabkan oleh stres berlebihan dan berkepanjangan.</p><h3>Tanda-tanda Burnout:</h3><ul><li>Kehilangan motivasi kerja.</li><li>Merasa tidak berdaya atau terjebak.</li><li>Menarik diri dari tanggung jawab.</li></ul><p>Cara mengatasinya adalah dengan menetapkan batasan (boundaries) yang jelas antara pekerjaan dan kehidupan pribadi. Mulailah dengan tidak mengecek email di luar jam kerja.</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Teknik Pernapasan 4-7-8',
                'category' => 'Mindfulness',
                'image_url' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=1200&auto=format&fit=crop',
                'summary' => 'Cara cepat menenangkan diri saat panik menyerang dalam hitungan menit.',
                'content' => '<p>Saat panik menyerang, napas kita cenderung pendek dan cepat. Teknik 4-7-8 adalah cara "reset" sistem saraf Anda.</p><h3>Caranya:</h3><ol><li>Tarik napas melalui hidung selama <strong>4 detik</strong>.</li><li>Tahan napas selama <strong>7 detik</strong>.</li><li>Hembuskan perlahan melalui mulut selama <strong>8 detik</strong> (seperti meniup lilin).</li></ol><p>Ulangi siklus ini sebanyak 4 kali. Ini akan memaksa detak jantung Anda melambat dan pikiran menjadi lebih tenang.</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Menjadi Pendengar Baik',
                'category' => 'Relationship',
                'image_url' => 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?q=80&w=1200&auto=format&fit=crop',
                'summary' => 'Bagaimana cara mendukung teman yang sedang mengalami masa sulit.',
                'content' => '<p>Seringkali teman kita curhat bukan butuh solusi, tapi butuh didengar. Menjadi pendengar aktif (Active Listening) adalah kunci hubungan yang sehat.</p><p>Hindari memotong pembicaraan atau langsung menghakimi. Cukup hadir, tatap matanya, dan validasi perasaannya dengan kalimat seperti "Aku paham itu pasti berat buat kamu".</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
