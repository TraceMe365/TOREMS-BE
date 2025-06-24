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
        Schema::create('tms_locations_p_to_p', function (Blueprint $table) {
            $table->bigIncrements('ptop_id');
            $table->unsignedBigInteger('cus_id')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('drop_off_location')->nullable();
            $table->decimal('total_mileage', 12, 2)->nullable();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->boolean('ptop_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_locations_p_to_p');
    }
};
