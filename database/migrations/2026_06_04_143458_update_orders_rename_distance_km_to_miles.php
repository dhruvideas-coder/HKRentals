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
            if (Schema::hasColumn('orders', 'distance_km')) {
                $table->renameColumn('distance_km', 'distance_miles');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'distance_miles')) {
                $table->renameColumn('distance_miles', 'distance_km');
            }
        });
    }
};
