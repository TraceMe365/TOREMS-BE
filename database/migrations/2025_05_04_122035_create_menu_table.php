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
        Schema::create('tms_menu', function (Blueprint $table) {
            $table->id();
            $table->string('tms_menu_icon');
            $table->string('tms_menu_name');
            $table->string('tms_menu_route');
            $table->integer('tms_menu_order');
            $table->string('tms_menu_package');
            $table->integer('tms_menu_parent');
            $table->integer('tms_menu_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_menu');
    }
};
