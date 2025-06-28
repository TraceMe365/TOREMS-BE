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
    Schema::table('tms_quotation', function (Blueprint $table) {
        $table->unsignedBigInteger('tms_shipment_id')->nullable()->after('id');
    });

    Schema::table('tms_shipment', function (Blueprint $table) {
        $table->unsignedBigInteger('quotation_id')->nullable()->after('tms_shp_id');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_quotation', function (Blueprint $table) {
            $table->dropColumn('tms_shipment_id');
        });
        Schema::table('tms_shipment', function (Blueprint $table) {
            $table->dropColumn('quotation_id');
        });
    }
};
