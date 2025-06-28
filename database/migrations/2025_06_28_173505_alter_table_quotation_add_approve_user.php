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
            $table->unsignedBigInteger('approve_user_id')->nullable()->after('status');
            $table->foreign('approve_user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('approve_time')->nullable()->after('approve_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tms_quotation', function (Blueprint $table) {
            $table->dropForeign(['approve_user_id']);
            $table->dropColumn('approve_user_id');
            $table->dropColumn('approve_time');
        });
    }
};
