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
        Schema::create('tms_customer_rate_master_route', function (Blueprint $table) {
            $table->bigIncrements('tms_route_rate_id');
            $table->unsignedBigInteger('cus_rate_id')->nullable();
            $table->unsignedBigInteger('tms_route_id')->nullable();
            $table->decimal('tms_route_rate_cost', 12, 2)->nullable();
            $table->decimal('tms_route_free_demurrage_less_hrs', 8, 2)->nullable();
            $table->decimal('tms_route_free_demurrage_less_cost', 12, 2)->nullable();
            $table->decimal('tms_route_free_demurrage_more_hrs', 8, 2)->nullable();
            $table->decimal('tms_route_free_demurrage_more_cost', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customer_rate_master_route');
    }
};
