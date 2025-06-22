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
        Schema::create('tms_trip_invoice_entry', function (Blueprint $table) {
            $table->bigIncrements('tms_ien_id');
            $table->unsignedBigInteger('tms_inv_id')->nullable();
            $table->string('tms_ien_request_id')->nullable();
            $table->date('tms_ien_request_date')->nullable();
            $table->string('tms_ien_pickup_location')->nullable();
            $table->string('tms_ien_dropoff_location')->nullable();
            $table->dateTime('tms_ien_trip_start')->nullable();
            $table->dateTime('tms_ien_trip_end')->nullable();
            $table->decimal('tms_ien_trip_spend', 12, 2)->nullable();
            $table->decimal('tms_ien_delivery', 12, 2)->nullable();
            $table->decimal('tms_ien_demurrage', 12, 2)->nullable();
            $table->decimal('tms_ien_other', 12, 2)->nullable();
            $table->decimal('tms_ien_loading', 12, 2)->nullable();
            $table->decimal('tms_ien_night_bata', 12, 2)->nullable();
            $table->string('tms_ien_trip_type')->nullable();
            $table->decimal('tms_ien_deduction', 12, 2)->nullable();
            $table->decimal('tms_trip_km', 12, 2)->nullable();
            $table->unsignedBigInteger('tms_ien_vehi_id')->nullable();
            $table->timestamps();

            $table->foreign('tms_inv_id')->references('tms_inv_id')->on('tms_trip_invoice')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_trip_invoice_entry');
    }
};
