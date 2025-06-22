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
        Schema::create('tms_vehicle_document', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('veh_id')->nullable()->comment('Reference to tms_vehicle');
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->foreign('veh_id')->references('veh_id')->on('tms_vehicle')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_vehicle_document');
    }
};
