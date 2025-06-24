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
        Schema::create('tms_customer_rate_master_p_to_p', function (Blueprint $table) {
            $table->bigIncrements('cus_ptop_id');
            $table->unsignedBigInteger('cus_rate_id')->nullable();
            $table->unsignedBigInteger('ptop_id')->nullable();
            $table->decimal('total_rate', 12, 2)->nullable();
            $table->decimal('aditional_cost_km', 12, 2)->nullable();
            $table->decimal('free_demurrage_less', 12, 2)->nullable();
            $table->decimal('free_demurrage_more', 12, 2)->nullable();
            $table->decimal('after_free_demurrage', 12, 2)->nullable();
            $table->decimal('after_free_demurrage_48', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customer_rate_master_p_to_p');
    }
};
