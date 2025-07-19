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
        Schema::table('tms_trip_invoice', function (Blueprint $table) {
            $table->string('tms_inv_proof')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_trip_invoice', function (Blueprint $table) {
            $table->dropColumn('tms_inv_proof');
        });
    }
};
