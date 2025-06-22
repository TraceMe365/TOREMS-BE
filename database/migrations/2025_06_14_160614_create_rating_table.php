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
        Schema::create('tms_rating', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id')->nullable()->comment('Related shipment');
            $table->unsignedBigInteger('customer_id')->nullable()->comment('Customer who rated');
            $table->tinyInteger('rating')->comment('Rating value, e.g. 1-5');
            $table->text('comment')->nullable()->comment('Optional feedback');
            $table->timestamps();

            $table->foreign('shipment_id')->references('tms_shp_id')->on('tms_shipment')->onDelete('set null');
            $table->foreign('customer_id')->references('cus_id')->on('tms_customer')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating');
    }
};
