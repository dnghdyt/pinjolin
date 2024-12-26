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
  }
}
