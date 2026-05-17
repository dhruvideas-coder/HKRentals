<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->date('rental_start_date')->nullable()->after('distance_km');
            $table->date('rental_end_date')->nullable()->after('rental_start_date');
            $table->dropColumn('event_date');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->date('event_date')->nullable()->after('distance_km');
            $table->dropColumn(['rental_start_date', 'rental_end_date']);
        });
    }
};
