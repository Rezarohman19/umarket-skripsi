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
        Schema::create('order_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->enum('tracking_status', [
                'picked_up',    // Pesanan diambil/disiapkan
                'on_the_way',   // Sedang dalam perjalanan
                'nearby',       // Sudah dekat lokasi pembeli
                'delivered',    // Sudah sampai
            ])->default('picked_up');
            $table->text('note')->nullable(); // Catatan dari seller (opsional)
            $table->timestamps();

            // Index untuk query cepat
            $table->index(['transaction_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tracking');
    }
};
