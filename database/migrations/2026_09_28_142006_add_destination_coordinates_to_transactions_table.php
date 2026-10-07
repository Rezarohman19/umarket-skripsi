<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah koordinat GPS tujuan pengiriman (buyer destination)
     * untuk fitur live tracking dengan rute navigasi seperti ShopeeFood.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('destination_lat', 10, 7)->nullable()->after('shipping_address');
            $table->decimal('destination_lng', 10, 7)->nullable()->after('destination_lat');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['destination_lat', 'destination_lng']);
        });
    }
};
