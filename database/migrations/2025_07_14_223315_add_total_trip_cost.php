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
            $table->double('tms_total_trip_cost')->nullable()->after('tms_shp_actial_trip_mileage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_shipment', function (Blueprint $table) {
            $table->dropColumn('tms_total_trip_cost');
        });
    }
};
