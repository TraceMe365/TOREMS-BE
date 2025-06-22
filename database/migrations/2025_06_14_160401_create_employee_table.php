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
        Schema::create('tms_employee', function (Blueprint $table) {
            $table->bigIncrements('emp_id');
            $table->unsignedBigInteger('sup_id')->nullable();
            $table->unsignedBigInteger('tms_com_id')->nullable();
            $table->unsignedBigInteger('tms_cus_id')->nullable();
            $table->unsignedBigInteger('cus_sup_id')->nullable();
            $table->string('emp_f_name')->nullable();
            $table->string('emp_s_name')->nullable();
            $table->string('emp_address')->nullable();
            $table->string('emp_id_card')->nullable();
            $table->string('emp_licence_card')->nullable();
            $table->string('emp_mobile')->nullable();
            $table->string('emp_home')->nullable();
            $table->string('emp_type')->nullable();
            $table->boolean('emp_status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('emp_doc_link')->nullable();
            $table->string('emp_pic_link')->nullable();
            $table->string('gs_object_id')->nullable();
            $table->boolean('emp_is_authenticated')->default(0);
            $table->dateTime('emp_last_activity')->nullable();
            $table->string('emp_otp')->nullable();
            $table->string('emp_device_mac')->nullable();
            $table->string('emp_token')->nullable();
            $table->string('emp_firebase_token')->nullable();
            $table->date('employee_license_expiry')->nullable();
            $table->date('emp_license_expiry')->nullable();
            $table->date('emp_police_expiry')->nullable();
            $table->string('emp_password')->nullable();
            $table->date('emp_grama_expiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_employee');
    }
};
