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
        Schema::create('tms_trip_invoice', function (Blueprint $table) {
            $table->bigIncrements('tms_inv_id');
            $table->unsignedBigInteger('tms_cus_id')->nullable();
            $table->unsignedBigInteger('tms_brch_id')->nullable();
            $table->string('tms_inv_no')->nullable();
            $table->date('tms_inv_date')->nullable();
            $table->string('tms_inv_mode')->nullable();
            $table->string('tms_inv_type')->nullable();
            $table->decimal('tms_inv_total_delivery', 12, 2)->nullable();
            $table->decimal('tms_inv_total_demurrage', 12, 2)->nullable();
            $table->decimal('tms_inv_total_other', 12, 2)->nullable();
            $table->decimal('tms_inv_total_deductions', 12, 2)->nullable();
            $table->decimal('tms_inv_total_loading', 12, 2)->nullable();
            $table->decimal('tms_inv_total_night_bata', 12, 2)->nullable();
            $table->decimal('tms_inv_net_amount', 12, 2)->nullable();
            $table->string('tms_inv_status')->nullable();
            $table->unsignedBigInteger('tms_inv_create_user')->nullable();
            $table->dateTime('tms_inv_create_date')->nullable();
            $table->unsignedBigInteger('tms_inv_processed_user')->nullable();
            $table->dateTime('tms_inv_processed_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_trip_invoice');
    }
};
