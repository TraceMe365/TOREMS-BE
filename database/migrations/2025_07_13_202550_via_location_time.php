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
        Schema::table('tms_via_location', function (Blueprint $table) {
            $table->timestamp('arrived_at')->nullable()->after('tms_quotation_id');
            $table->timestamp('departed_at')->nullable()->after('tms_quotation_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_via_location', function (Blueprint $table) {
            $table->dropColumn(['arrived_at', 'departed_at']);
        });
    }
};
