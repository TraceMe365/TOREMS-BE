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
        Schema::create('tms_via_location', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_shipment_id')->nullable();
            $table->string('via_location')->nullable();
            $table->decimal('via_latitude', 10, 7)->nullable();
            $table->decimal('via_longitude', 10, 7)->nullable();
            $table->unsignedBigInteger('tms_quotation_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_via_location');
    }
};
