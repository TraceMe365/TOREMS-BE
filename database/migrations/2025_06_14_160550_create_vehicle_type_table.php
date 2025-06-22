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
        Schema::create('tms_vehicle_type', function (Blueprint $table) {
            $table->bigIncrements('veh_type_id');
            $table->string('veh_type')->nullable();
            $table->string('veh_type_specification')->nullable();
            $table->decimal('veh_efficiency', 8, 2)->nullable();
            $table->boolean('veh_type_status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('tms_com_id')->nullable();
            $table->unsignedBigInteger('tms_cus_id')->nullable();
            $table->decimal('veh_capacity', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_vehicle_type');
    }
};
