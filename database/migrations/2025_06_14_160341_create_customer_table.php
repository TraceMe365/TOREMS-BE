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
        Schema::create('tms_customer', function (Blueprint $table) {
            $table->id('cus_id');
            $table->string('cus_code')->nullable();
            $table->string('cus_name');
            $table->string('cus_address')->nullable();
            $table->string('cus_con_person')->nullable();
            $table->string('cus_con_person_num')->nullable();
            $table->string('cus_con_person_email')->nullable();
            $table->text('cus_other_details')->nullable();
            $table->boolean('cus_status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('tms_package')->nullable();
            $table->unsignedBigInteger('tms_com_id')->nullable();
            $table->string('start_loc_type')->nullable();
            $table->string('end_loc_type')->nullable();
            $table->decimal('aditional_mileage_pre', 10, 2)->nullable();
            $table->string('cus_vat_number')->nullable();
            $table->string('cus_nbt_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_customer');
    }
};
