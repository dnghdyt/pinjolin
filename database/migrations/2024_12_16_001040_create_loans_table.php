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
    Schema::create('loans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('nasabah_id')
        ->constrained('nasabahs')
        ->onDelete('cascade');
      $table->integer('loan_amount');
      $table->decimal('interest_rate', 4, 2);
      $table->enum('tenor', ['3', '6', '12', '18', '24']);
      $table->timestamp('loan_disbursement_date');
      $table->enum('status_loan', ['pending', 'approved', 'completed']);
      $table->softDeletes();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('loans');
  }
};
