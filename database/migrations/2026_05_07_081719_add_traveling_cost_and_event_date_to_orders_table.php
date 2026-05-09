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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('traveling_cost', 10, 2)->default(0)->after('total_amount');
            $table->decimal('distance_km', 10, 2)->nullable()->after('traveling_cost');
            $table->date('event_date')->nullable()->after('distance_km');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['traveling_cost', 'distance_km', 'event_date']);
        });
    }
};
