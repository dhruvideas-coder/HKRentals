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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('godown_address')->nullable();
            $table->string('godown_lat')->nullable();
            $table->string('godown_lng')->nullable();
            $table->decimal('free_delivery_distance', 8, 2)->default(5.00); // 5 km
            $table->decimal('charge_per_km', 8, 2)->default(1.00); // $1 / km
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
