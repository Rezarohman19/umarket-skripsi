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
        Schema::table('store_visits', function (Blueprint $table) {
            $table->index('store_id');
            $table->dropUnique('store_visits_store_id_ip_address_visit_date_unique');
            $table->index(['store_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_visits', function (Blueprint $table) {
            $table->dropIndex(['store_id', 'created_at']);
            $table->unique(['store_id', 'ip_address', 'visit_date']);
        });
    }
};
