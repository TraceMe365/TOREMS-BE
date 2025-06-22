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
        Schema::create('tms_vehicle', function (Blueprint $table) {
            $table->bigIncrements('veh_id');
            $table->string('veh_no')->nullable();
            $table->string('veh_shr_mode')->nullable();
            $table->unsignedBigInteger('cus_sup_id')->nullable();
            $table->string('veh_uniq_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->decimal('veh_loading_capacity', 12, 2)->nullable();
            $table->string('veh_eng_no')->nullable();
            $table->string('veh_chassis')->nullable();
            $table->date('veh_f_reg_date')->nullable();
            $table->date('veh_ins_ren_date')->nullable();
            $table->date('veh_lic_ren_date')->nullable();
            $table->boolean('veh_status')->default(1);
            $table->boolean('veh_availability')->default(1);
            $table->integer('veh_daily_shipmenmt_count')->nullable();
            $table->decimal('tms_veh_turnaround_time', 8, 2)->nullable();
            $table->boolean('veh_gps_status')->default(0);
            $table->boolean('veh_permanent')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('veh_diver_id')->nullable();
            $table->unsignedBigInteger('veh_hepler_id')->nullable();
            $table->string('veh_image_link')->nullable();
            $table->integer('veh_ot_duration')->nullable();
            $table->decimal('veh_ot_rate', 12, 2)->nullable();
            $table->decimal('veh_ot_rate_sup', 12, 2)->nullable();
            $table->string('gs_object_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('veh_vehicle_mode')->nullable();
            $table->boolean('veh_is_available')->default(1);
            $table->date('veh_insurance_expiry')->nullable();
            $table->date('veh_emission_expiry')->nullable();
            $table->date('veh_revenue_expiry')->nullable();
            $table->date('veh_registration_expiry')->nullable();
            $table->date('veh_license_expiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_vehicle');
    }
};
