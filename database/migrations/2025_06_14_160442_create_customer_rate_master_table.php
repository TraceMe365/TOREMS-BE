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
        Schema::create('tms_customer_rate_master', function (Blueprint $table) {
            $table->bigIncrements('cus_rate_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('veh_type_id')->nullable();
            $table->unsignedBigInteger('capacity_id')->nullable();
            $table->string('type_of_rates')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('rate_request_status')->nullable();
            $table->unsignedBigInteger('rate_request_conf_by_user_id')->nullable();
            $table->unsignedBigInteger('rate_submited_by')->nullable();
            $table->dateTime('rate_requested_date')->nullable();
            $table->dateTime('rate_request_conf_date')->nullable();
            $table->string('cms_status')->nullable();
            $table->string('commitment_type')->nullable();
            $table->string('demurrage_type')->nullable();
            $table->decimal('demurrage_hrs', 8, 2)->nullable();
            $table->decimal('demurrage_cost', 12, 2)->nullable();
            $table->decimal('exceed_km_rate', 12, 2)->nullable();
            $table->decimal('exceed_per_km_rate', 12, 2)->nullable();
            $table->decimal('loading_only', 12, 2)->nullable();
            $table->decimal('first_trip_rate', 12, 2)->nullable();
            $table->decimal('second_trip_rate', 12, 2)->nullable();
            $table->decimal('commitment_km', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customer_rate_master');
    }
};
