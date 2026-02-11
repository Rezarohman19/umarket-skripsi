<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'order_id')) {
                $table->string('order_id')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('transactions', 'midtrans_transaction_id')) {
                $table->string('midtrans_transaction_id')->nullable()->index()->after('order_id');
            }
            if (!Schema::hasColumn('transactions', 'merchant_id')) {
                $table->string('merchant_id')->nullable()->after('midtrans_transaction_id');
            }
            if (!Schema::hasColumn('transactions', 'transaction_type')) {
                $table->string('transaction_type')->nullable()->after('merchant_id');
            }
            if (!Schema::hasColumn('transactions', 'status_code')) {
                $table->string('status_code', 10)->nullable()->after('transaction_type');
            }
            if (!Schema::hasColumn('transactions', 'status_message')) {
                $table->string('status_message')->nullable()->after('status_code');
            }
            if (!Schema::hasColumn('transactions', 'fraud_status')) {
                $table->string('fraud_status', 20)->nullable()->after('status_message');
            }
            if (!Schema::hasColumn('transactions', 'transaction_time')) {
                $table->dateTime('transaction_time')->nullable()->after('fraud_status');
            }
            if (!Schema::hasColumn('transactions', 'expiry_time')) {
                $table->dateTime('expiry_time')->nullable()->after('transaction_time');
            }
            if (!Schema::hasColumn('transactions', 'signature_key')) {
                $table->text('signature_key')->nullable()->after('expiry_time');
            }
            if (!Schema::hasColumn('transactions', 'midtrans_payload')) {
                $table->json('midtrans_payload')->nullable()->after('signature_key');
            }
            if (!Schema::hasColumn('transactions', 'customer_full_name')) {
                $table->string('customer_full_name')->nullable()->after('midtrans_payload');
            }
            if (!Schema::hasColumn('transactions', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_full_name');
            }
            if (!Schema::hasColumn('transactions', 'currency')) {
                $table->string('currency', 5)->nullable()->after('customer_email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $cols = [];
            foreach ([
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
            ] as $col) {
                if (Schema::hasColumn('transactions', $col)) {
                    $cols[] = $col;
                }
            }
            if (count($cols) > 0) {
                $table->dropColumn($cols);
            }
        });
    }
};
