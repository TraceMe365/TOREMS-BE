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
        Schema::create('tms_customer_rate_master_day_commitment', function (Blueprint $table) {
            $table->bigIncrements('tms_crd_id');
            $table->unsignedBigInteger('cus_rate_id')->nullable();
            $table->decimal('tms_crd_minimum_km', 12, 2)->nullable();
            $table->decimal('tms_crd_commitment_rate', 12, 2)->nullable();
            $table->decimal('tms_crd_excess_rate_per_km', 12, 2)->nullable();
            $table->integer('tms_crd_trip_per_day')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customer_rate_master_day_commitment');
    }
};
