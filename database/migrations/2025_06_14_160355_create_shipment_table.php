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
        Schema::create('tms_shipment', function (Blueprint $table) {
            $table->bigIncrements('tms_shp_id');
            $table->string('tms_shp_order_id')->nullable();
            $table->string('tms_shp_request_no')->nullable();
            $table->string('tms_shp_order_number')->nullable();
            $table->unsignedBigInteger('tms_cus_id')->nullable();
            $table->unsignedBigInteger('tms_brch_id')->nullable();
            $table->unsignedBigInteger('tms_plnt_id')->nullable();
            $table->unsignedBigInteger('tms_dep_id')->nullable();
            $table->unsignedBigInteger('tms_vty_id')->nullable();
            $table->unsignedBigInteger('tms_cpt_id')->nullable();
            $table->unsignedBigInteger('tms_veh_id')->nullable();
            $table->unsignedBigInteger('tms_shp_supplier_send_vehi_id')->nullable();
            $table->unsignedBigInteger('tms_shp_supplier_billing_vehi_id')->nullable();
            $table->string('tms_shp_mode')->nullable();
            $table->string('tms_shp_qty_type')->nullable();
            $table->decimal('tms_shp_delivery_qty', 12, 2)->nullable();
            $table->decimal('vehi_allocated_qty', 12, 2)->nullable();
            $table->decimal('vehi_utilization', 12, 2)->nullable();
            $table->decimal('vehi_utilization_cbm', 12, 2)->nullable();
            $table->decimal('vehi_utilization_weight', 12, 2)->nullable();
            $table->date('tms_shp_request_date')->nullable();
            $table->string('tms_shp_contact_person')->nullable();
            $table->string('tms_shp_contact_no')->nullable();
            $table->string('tms_shp_email')->nullable();
            $table->string('tms_shp_trip_mode')->nullable();
            $table->string('tms_shp_trip_type')->nullable();
            $table->string('tms_shp_cus_commitment_type')->nullable();
            $table->string('tms_shp_sup_trip_type')->nullable();
            $table->string('tms_shp_sup_commitment_type')->nullable();
            $table->string('tms_shp_pay_for')->nullable();
            $table->string('tms_shp_shipment_type')->nullable();
            $table->string('tms_shp_driver')->nullable();
            $table->string('tms_shp_helper')->nullable();
            $table->string('tms_shp_request_loc')->nullable();
            $table->string('tms_shp_pickup_loc')->nullable();
            $table->string('tms_shp_delivery_loc')->nullable();
            $table->string('tms_shp_delivery_loc_dtype')->nullable();
            $table->string('tms_shp_pickup_address')->nullable();
            $table->string('tms_shp_delivery_address')->nullable();
            $table->date('tms_shp_pickup_date')->nullable();
            $table->string('tms_shp_pickup_time')->nullable();
            $table->date('tms_shp_delivery_date')->nullable();
            $table->string('tms_shp_delivery_time')->nullable();
            $table->date('tms_shp_arrival_date')->nullable();
            $table->string('tms_shp_arrival_time')->nullable();
            $table->date('tms_shp_dispatch_date')->nullable();
            $table->string('tms_shp_dispatch_time')->nullable();
            $table->decimal('tms_shp_total_mileage', 12, 2)->nullable();
            $table->decimal('tms_shp_estimated_mileage', 12, 2)->nullable();
            $table->decimal('tms_shp_actial_trip_mileage', 12, 2)->nullable();
            $table->decimal('tms_shp_trip_cost', 12, 2)->nullable();
            $table->decimal('tms_shp_additional_cost_per', 12, 2)->nullable();
            $table->decimal('tms_shp_demurrage_amount_customer', 12, 2)->nullable();
            $table->decimal('tms_shp_other_amount', 12, 2)->nullable();
            $table->string('tms_shp_consignee_buyer')->nullable();
            $table->string('tms_shp_consignment_type')->nullable();
            $table->string('tms_shp_import_no')->nullable();
            $table->string('tms_shp_bl_no')->nullable();
            $table->string('tms_shp_air_way_no')->nullable();
            $table->string('tms_shp_reference')->nullable();
            $table->string('tms_shp_security_no')->nullable();
            $table->text('tms_shp_remarks')->nullable();
            $table->text('tms_shp_dispute_remark')->nullable();
            $table->string('tms_shp_status')->nullable();
            $table->unsignedBigInteger('tms_shp_create_user')->nullable();
            $table->dateTime('tms_shp_create_date')->nullable();
            $table->unsignedBigInteger('tms_ship_accepeted_user')->nullable();
            $table->dateTime('tms_ship_accepted_date')->nullable();
            $table->unsignedBigInteger('tms_shp_approved_user')->nullable();
            $table->dateTime('tms_shp_approved_date')->nullable();
            $table->boolean('isInvoice')->default(0);
            $table->boolean('isSupplier_invoice')->default(0);
            $table->boolean('tms_shp_arrived_pickup')->default(0);
            $table->boolean('tms_shp_departed_pickup')->default(0);
            $table->boolean('tms_shp_attended')->default(0);
            $table->boolean('tms_shp_arrived_delivery')->default(0);
            $table->boolean('tms_shp_departed_delivery')->default(0);
            $table->boolean('tms_shp_arrived_delivery_temp')->default(0);
            $table->boolean('tms_shp_departed_delivery_temp')->default(0);
            $table->dateTime('tms_shp_shipment_start')->nullable();
            $table->dateTime('tms_shp_shipment_end')->nullable();
            $table->decimal('tms_shp_shipment_spend', 12, 2)->nullable();
            $table->unsignedBigInteger('srm_supplier_id')->nullable();
            $table->decimal('srm_commitment_km', 12, 2)->nullable();
            $table->decimal('srm_rete_commitment_km', 12, 2)->nullable();
            $table->decimal('srm_first_trip_rate', 12, 2)->nullable();
            $table->decimal('srm_second_trip_rate', 12, 2)->nullable();
            $table->decimal('tms_shp_supplier_rate', 12, 2)->nullable();
            $table->decimal('srm_supplier_requested_rate', 12, 2)->nullable();
            $table->string('tms_shp_supplier_trip_mode')->nullable();
            $table->string('tms_shp_customer_trip_mode')->nullable();
            $table->decimal('tms_shp_shipment_start_mileage', 12, 2)->nullable();
            $table->decimal('tms_shp_shipment_end_mileage', 12, 2)->nullable();
            $table->boolean('tms_shp_pickup_door_open')->default(0);
            $table->boolean('tms_shp_pickup_door_close')->default(0);
            $table->boolean('tms_shp_deliver_door_open')->default(0);
            $table->boolean('tms_shp_deliver_door_close')->default(0);
            $table->decimal('tms_shp_loading_charge', 12, 2)->nullable();
            $table->decimal('tms_shp_highway_charge', 12, 2)->nullable();
            $table->decimal('tms_shp_deductions', 12, 2)->nullable();
            $table->decimal('tms_shp_night_bata', 12, 2)->nullable();
            $table->boolean('tms_shp_gps_track')->default(0);
            $table->decimal('tms_shp_cbm', 12, 2)->nullable();
            $table->decimal('tms_shp_weight', 12, 2)->nullable();
            $table->boolean('tms_shp_epod_report')->default(0);
            $table->string('tms_shp_inv_no')->nullable();
            $table->decimal('tms_shp_demurrage_amount_supplier', 12, 2)->nullable();
            $table->decimal('tms_shp_demurrage_hrs', 12, 2)->nullable();
            $table->decimal('tms_shp_demurrage_amount', 12, 2)->nullable();
            $table->boolean('tms_shp_late_booking')->default(0);
            $table->string('tms_shp_placement_status')->nullable();
            $table->string('tms_shp_container_type')->nullable();
            $table->string('tms_shp_container_number')->nullable();
            $table->string('tms_shp_ref_po_number')->nullable();
            $table->date('tms_shp_cut_off_date')->nullable();
            $table->decimal('tms_shp_unloading_charge', 12, 2)->nullable();
            $table->decimal('tms_shp_boi_charge', 12, 2)->nullable();
            $table->string('tms_shp_shipment_doc')->nullable();
            $table->string('tms_shp_cnt_doc')->nullable();
            $table->string('tms_shp_attended_by')->nullable();
            $table->string('tms_shp_arrived_at_pickup_by')->nullable();
            $table->string('tms_shp_started_by')->nullable();
            $table->string('tms_shp_completed_by')->nullable();
            $table->string('tms_shp_SAP_REF')->nullable();
            $table->boolean('tms_shp_isSAP_data_passed')->default(0);
            $table->boolean('tms_shp_isSAP_customer_data_passed')->default(0);
            $table->boolean('tms_shp_isSAP_supplier_data_passed')->default(0);
            $table->decimal('tms_shp_supplier_night_bata', 12, 2)->nullable();
            $table->decimal('tms_shp_supplier_highway', 12, 2)->nullable();
            $table->decimal('tms_shp_supplier_loading', 12, 2)->nullable();
            $table->decimal('tms_shp_supplier_unloading', 12, 2)->nullable();
            $table->decimal('tms_shp_supplier_boi', 12, 2)->nullable();
            $table->decimal('tms_shp_supplier_other_charges', 12, 2)->nullable();
            $table->decimal('tms_shp_supplier_deduction', 12, 2)->nullable();
            $table->boolean('tms_shp_send_to_csv')->default(0);
            $table->unsignedBigInteger('tms_shp_route_id')->nullable();
            $table->string('tms_ship_cargo_status')->nullable();
            $table->dateTime('tms_ship_attended_date')->nullable();
            $table->dateTime('tms_ship_canceled_date')->nullable();
            $table->boolean('tms_shp_visited')->default(0);
            $table->string('tms_shp_not_visited_reson')->nullable();
            $table->string('tms_shp_priority')->nullable();
            $table->string('delivery_priority')->nullable();
            $table->dateTime('tms_shp_estimated_in')->nullable();
            $table->dateTime('tms_shp_estimated_out')->nullable();
            $table->boolean('tms_is_gate_pass_print')->default(0);
            $table->decimal('tms_start_odometer', 12, 2)->nullable();
            $table->decimal('tms_end_odometer', 12, 2)->nullable();
            $table->decimal('tms_shp_driver_salary', 12, 2)->nullable();
            $table->decimal('tms_shp_helper_salary', 12, 2)->nullable();
            $table->dateTime('tms_shp_pickup_in_datetime')->nullable();
            $table->dateTime('tms_shp_pickup_out_datetime')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tms_shipment');
    }
};
