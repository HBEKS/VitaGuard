<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Standar Industri untuk transaksi
            $table->foreignUuid('member_id')->constrained('users')->onDelete('cascade');
            $table->foreignUuid('doctor_id')->constrained('users')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->decimal('consultation_fee', 12, 2); // Snapshot tarif dokter
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled']);
            $table->text('member_complaint')->nullable(); // Keluhan dari pasien
            $table->text('doctor_notes')->nullable(); // Catatan riwayat dari dokter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
