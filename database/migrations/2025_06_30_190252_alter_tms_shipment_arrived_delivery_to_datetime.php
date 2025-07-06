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
        Schema::table('tms_shipment', function (Blueprint $table) {
            $table->dateTime('tms_shp_arrived_delivery')->nullable()->change();
            $table->dateTime('tms_shp_arrived_pickup')->nullable()->change();
            $table->dateTime('tms_shp_departed_delivery')->nullable()->change();
            $table->dateTime('tms_shp_departed_pickup')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_shipment', function (Blueprint $table) {
            //
        });
    }
};
