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
        Schema::create('tms_customer_rate_master_per_km', function (Blueprint $table) {
            $table->bigIncrements('per_km_id');
            $table->unsignedBigInteger('cus_rate_id')->nullable();
            $table->decimal('minimum_km', 12, 2)->nullable();
            $table->decimal('minimum_km_rate', 12, 2)->nullable();
            $table->decimal('minimum_km_rate_after', 12, 2)->nullable();
            $table->decimal('free_demurrage_less', 12, 2)->nullable();
            $table->decimal('free_demurrage_more', 12, 2)->nullable();
            $table->decimal('after_free_demurrage', 12, 2)->nullable();
            $table->integer('day_trip_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customer_rate_master_per_km');
    }
};
