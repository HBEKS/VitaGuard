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
    Schema::create('transactions', function (Blueprint $table) {
        // Karena seeder kamu pakai Str::uuid(), gunakan uuid sebagai primary key
        $table->uuid('id')->primary();

        // Menghubungkan ke tabel appointments (pastikan tabel appointments pakai UUID juga)
        $table->foreignUuid('appointment_id')->constrained('appointments')->onDelete('cascade');

        $table->integer('amount');
        $table->string('payment_method');
        $table->string('payment_status');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
