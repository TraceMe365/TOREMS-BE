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
        Schema::create('tms_customer_rate_master_slab', function (Blueprint $table) {
            $table->bigIncrements('cus_slab_rate_id');
            $table->unsignedBigInteger('cus_rate_id')->nullable();
            $table->decimal('cus_slab_minimum_km', 12, 2)->nullable();
            $table->decimal('cus_slab_fixed_rate', 12, 2)->nullable();
            $table->decimal('cus_slab_1st_slab', 12, 2)->nullable();
            $table->decimal('cus_slab_2nd_slab', 12, 2)->nullable();
            $table->decimal('cus_slab_3rd_slab', 12, 2)->nullable();
            $table->decimal('cus_slab_dem_less_free_hrs', 8, 2)->nullable();
            $table->decimal('cus_slab_dem_less_rate', 12, 2)->nullable();
            $table->decimal('cus_slab_dem_more_free_hrs', 8, 2)->nullable();
            $table->decimal('cus_slab_dem_more_rate', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customer_rate_master_slab');
    }
};
