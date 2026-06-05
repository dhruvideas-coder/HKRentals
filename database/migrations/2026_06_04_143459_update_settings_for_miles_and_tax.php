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
        // Step 1: rename charge_per_km → charge_per_mile (separate call so hasColumn reflects the change)
        if (Schema::hasColumn('settings', 'charge_per_km')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->renameColumn('charge_per_km', 'charge_per_mile');
            });
        }

        // Step 2: drop free_delivery_distance
        if (Schema::hasColumn('settings', 'free_delivery_distance')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('free_delivery_distance');
            });
        }

        // Step 3: add charge_per_mile if still missing
        if (!Schema::hasColumn('settings', 'charge_per_mile')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->decimal('charge_per_mile', 8, 2)->default(1.00)->after('godown_lng');
            });
        }

        // Step 4: add max_delivery_distance
        if (!Schema::hasColumn('settings', 'max_delivery_distance')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->decimal('max_delivery_distance', 8, 2)->default(20.00)->after('charge_per_mile');
            });
        }

        // Step 5: add tax_rate
        if (!Schema::hasColumn('settings', 'tax_rate')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->decimal('tax_rate', 5, 2)->default(9.25)->after('max_delivery_distance');
            });
        }
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'charge_per_mile')) {
                $table->renameColumn('charge_per_mile', 'charge_per_km');
            }
            if (!Schema::hasColumn('settings', 'free_delivery_distance')) {
                $table->decimal('free_delivery_distance', 8, 2)->default(5.00)->after('godown_lng');
            }
            if (Schema::hasColumn('settings', 'max_delivery_distance')) {
                $table->dropColumn('max_delivery_distance');
            }
            if (Schema::hasColumn('settings', 'tax_rate')) {
                $table->dropColumn('tax_rate');
            }
        });
    }
};
