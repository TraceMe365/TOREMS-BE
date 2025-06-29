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
            $table->unsignedBigInteger('origin_id')->nullable()->after('quotation_date');
            $table->unsignedBigInteger('destination_id')->nullable()->after('origin_id');
        });

        Schema::table('tms_via_location', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable()->after('via_longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_quotation', function (Blueprint $table) {
            $table->dropColumn(['origin_id', 'destination_id']);
        });
        Schema::table('tms_via_location', function (Blueprint $table) {
        $table->dropColumn('location_id');
    });
    }
};
