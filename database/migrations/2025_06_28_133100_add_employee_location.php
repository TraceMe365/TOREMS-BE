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
        Schema::table('tms_employee', function (Blueprint $table) {
            $table->decimal('current_latitude', 10, 7)->nullable()->after('emp_address');
            $table->decimal('current_longitude', 10, 7)->nullable()->after('emp_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_quotation', function (Blueprint $table) {
            if (Schema::hasColumn('tms_quotation', 'current_latitude')) {
                $table->dropColumn('current_latitude');
            }
            if (Schema::hasColumn('tms_quotation', 'current_longitude')) {
                $table->dropColumn('current_longitude');
            }
        });
    }
};
