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
        Schema::create('tms_location', function (Blueprint $table) {
            $table->bigIncrements('loc_id');
            $table->unsignedBigInteger('tms_are_id')->nullable();
            $table->string('loc_code')->nullable();
            $table->string('loc_sap_code')->nullable();
            $table->unsignedBigInteger('cus_sup_id')->nullable();
            $table->string('loc_resourse')->nullable();
            $table->string('loc_uniq_id')->nullable();
            $table->unsignedBigInteger('cus_id')->nullable();
            $table->string('loc_name')->nullable();
            $table->string('loc_address')->nullable();
            $table->text('loc_other')->nullable();
            $table->string('loc_type')->nullable();
            $table->string('loc_status')->default(1);
            $table->decimal('loc_turn_around_time', 8, 2)->nullable();
            $table->decimal('loc_lat', 11, 8)->nullable();
            $table->decimal('loc_long', 11, 8)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('loc_contact_person')->nullable();
            $table->string('loc_contact_mobile')->nullable();
            $table->string('loc_contact_other')->nullable();
            $table->string('loc_priority_level')->nullable();
            $table->decimal('loc_distance', 10, 2)->nullable();
            $table->boolean('loc_excess_calculate')->default(0);
            $table->decimal('loc_loading_charge', 12, 2)->nullable();
            $table->string('loc_vehi_mode')->nullable();
            $table->string('loc_vehi_type')->nullable();
            $table->unsignedBigInteger('loc_city_id')->nullable();
            $table->string('filled')->nullable();
            $table->string('loc_sap_cost_center')->nullable();
            $table->string('loc_sap_purchase_group')->nullable();
            $table->string('loc_sap_branch_id')->nullable();
            $table->timestamp('loc_sync_timestamp')->nullable();
            $table->boolean('is_recorrect_loc')->default(0);
            $table->boolean('is_with_geofence')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_location');
    }
};
