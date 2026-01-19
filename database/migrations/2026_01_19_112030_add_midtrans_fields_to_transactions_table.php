<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Identitas transaksi Midtrans (untuk callback lookup)
            $table->string('order_id')->nullable()->unique()->after('id'); // contoh: ORDER-8-1768820540
            $table->string('midtrans_transaction_id')->nullable()->index()->after('order_id'); // transaction_id
            $table->string('merchant_id')->nullable()->after('midtrans_transaction_id');

            // Status & metadata dari Midtrans
            $table->string('transaction_type')->nullable()->after('merchant_id');
            $table->string('status_code', 10)->nullable()->after('transaction_type');
            $table->string('status_message')->nullable()->after('status_code');
            $table->string('fraud_status', 20)->nullable()->after('status_message');

            // Waktu dari Midtrans (pakai datetime nullable)
            $table->dateTime('transaction_time')->nullable()->after('fraud_status');
            $table->dateTime('expiry_time')->nullable()->after('transaction_time');

            // Keamanan & audit
            $table->text('signature_key')->nullable()->after('expiry_time');

            // Simpan payload mentah (berguna buat debug)
            $table->json('midtrans_payload')->nullable()->after('signature_key');

            // Snapshot customer (opsional)
            $table->string('customer_full_name')->nullable()->after('midtrans_payload');
            $table->string('customer_email')->nullable()->after('customer_full_name');

            // currency (opsional)
            $table->string('currency', 5)->nullable()->after('customer_email');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'order_id',
                'midtrans_transaction_id',
                'merchant_id',
                'transaction_type',
                'status_code',
                'status_message',
                'fraud_status',
                'transaction_time',
                'expiry_time',
                'signature_key',
                'midtrans_payload',
                'customer_full_name',
                'customer_email',
                'currency',
            ]);
        });
    }
};
