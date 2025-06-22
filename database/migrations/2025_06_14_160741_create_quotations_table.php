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
        Schema::create('tms_quotation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable()->comment('Reference to tms_customer');
            $table->string('quotation_no')->nullable();
            $table->date('quotation_date')->nullable();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->decimal('rate', 12, 2)->nullable();
            $table->string('rate_type')->nullable();
            $table->decimal('estimated_distance', 12, 2)->nullable();
            $table->decimal('estimated_time', 12, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('cus_id')->on('tms_customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_quotation');
    }
};
