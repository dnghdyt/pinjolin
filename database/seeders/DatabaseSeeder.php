<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Loan;
use App\Models\User;
use App\Models\Nasabah;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // User::factory(10)->create();

    // User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    User::create([
      "name" => "Bubble Smith",
      "email" => "admin@example.com",
      "email_verified_at" => now(),
      "password" => bcrypt("@Admin123")
    ]);

    DB::table('categories')->insert([
      [
          'category_name' => 'Panduan Keuangan',
          'description' => 'Kategori ini berisi panduan dan tips untuk mengelola keuangan dengan baik, termasuk memilih pinjaman online yang aman.',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'category_name' => 'Informasi Pinjaman',
          'description' => 'Artikel-artikel dalam kategori ini membahas berbagai jenis pinjaman online dan perbandingannya dengan pinjaman tradisional.',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'category_name' => 'Tips & Trik',
          'description' => 'Kategori ini berisi tips mengelola utang, meningkatkan skor kredit, dan menghindari penipuan pinjaman online.',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'category_name' => 'Keamanan Finansial',
          'description' => 'Artikel dalam kategori ini fokus pada edukasi dan perlindungan dari pinjaman online ilegal atau berisiko tinggi.',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'category_name' => 'Berita & Update',
          'description' => 'Kategori ini memberikan informasi terkini terkait dunia fintech, regulasi, dan layanan pinjaman online.',
          'created_at' => now(),
          'updated_at' => now(),
      ],
  ]);

    DB::table('articles')->insert([
      [
          'user_id' => 1,
          'category_id' => 1,
          'title' => 'Panduan Memilih Pinjaman Online yang Aman',
          'slug' => 'Panduan Memilih Pinjaman Online yang Aman',
          'description' => 'Tips dan trik untuk memilih layanan pinjaman online yang terpercaya.',
          'content' => 'Pinjaman online dapat menjadi solusi finansial, tetapi Anda perlu berhati-hati. Pilih platform yang memiliki izin resmi dan transparan dalam memberikan informasi.',
          'status' => 'published',
          'thumbnail' => 'https://i.pinimg.com/736x/41/fc/6e/41fc6e0ab674362ec4a8390f35e8860e.jpg',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'user_id' => 1,
          'category_id' => 1,
          'title' => 'Manfaat dan Risiko Pinjaman Online',
          'slug' => 'Manfaat dan Risiko Pinjaman Online',
          'description' => 'Membahas keuntungan dan potensi risiko dalam menggunakan layanan pinjaman online.',
          'content' => 'Pinjaman online memberikan kemudahan akses, tetapi ada risiko seperti bunga tinggi. Penting untuk memahami ketentuan sebelum mengajukan.',
          'status' => 'published',
          'thumbnail' => 'https://i.pinimg.com/236x/50/07/16/500716ecb050062fa8d85c897465282f.jpg',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'user_id' => 1,
          'category_id' => 2,
          'title' => 'Perbandingan Pinjaman Online dengan Bank Tradisional',
          'slug' => 'Perbandingan Pinjaman Online dengan Bank Tradisional',
          'description' => 'Artikel ini membandingkan kelebihan dan kekurangan pinjaman online dibandingkan bank.',
          'content' => 'Bank tradisional menawarkan keamanan, sementara pinjaman online menawarkan kecepatan. Pilihan tergantung pada kebutuhan Anda.',
          'status' => 'published',
          'thumbnail' => 'https://i.pinimg.com/236x/fb/64/6d/fb646d80efbf4c6f51ff30bfbfd4ce15.jpg',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'user_id' => 1,
          'category_id' => 2,
          'title' => 'Tips Mengelola Utang dari Pinjaman Online',
          'slug' => 'Tips Mengelola Utang dari Pinjaman Online',
          'description' => 'Strategi untuk mengelola pinjaman online agar tidak memberatkan keuangan.',
          'content' => 'Mengelola utang dengan baik adalah kunci keuangan yang sehat. Bayar tepat waktu dan gunakan dana pinjaman untuk kebutuhan produktif.',
          'status' => 'draft',
          'thumbnail' => 'https://i.pinimg.com/236x/79/e7/33/79e73332a01c082e167f1320437c92f4.jpg',
          'created_at' => now(),
          'updated_at' => now(),
      ],
      [
          'user_id' => 1,
          'category_id' => 3,
          'title' => 'Kenali Ciri-ciri Pinjaman Online Ilegal',
          'slug' => 'Kenali Ciri-ciri Pinjaman Online Ilegal',
          'description' => 'Informasi penting untuk menghindari pinjaman online yang tidak resmi.',
          'content' => 'Pinjaman ilegal biasanya tidak memiliki izin resmi, memberikan bunga yang tidak wajar, dan menggunakan cara penagihan yang tidak etis.',
          'status' => 'published',
          'thumbnail' => 'https://i.pinimg.com/236x/23/80/23/238023f7b45e09ee26adae5c52508c63.jpg',
          'created_at' => now(),
          'updated_at' => now(),
      ],
  ]);
  }
}
