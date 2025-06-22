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
        Schema::create('tms_role', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Role name');
            $table->string('status')->default('active')->comment('Role status');
            $table->string('description')->nullable()->comment('Role description');
            $table->string('slug')->unique()->comment('Role slug for URL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_role');
    }
};
