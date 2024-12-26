<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('nasabahs', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->text('address');
      $table->string('phone_number');
      $table->string('email')->unique();
      $table->timestamp('date_of_birth');
      $table->enum('gender', ['male', 'female']);
      $table->string('id_card');
      $table->string('id_card_number', 16);
      $table->string('selfie');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('nasabahs');
  }
};
