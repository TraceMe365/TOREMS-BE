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
        Schema::create('tms_employee_document', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->comment('Employee ID')->references('emp_id')->on('tms_employee')->onDelete('cascade');
            $table->string('document_type')->nullable();
            $table->string('document_name')->nullable();
            $table->string('document_path')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_employee_document');
    }
};
