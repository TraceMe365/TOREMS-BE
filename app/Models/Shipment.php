<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = 'tms_shipment';
    protected $primaryKey = 'tms_shp_id';

    protected $fillable = [
        'tms_shp_order_id',
        'quotation_id',
        'tms_shp_request_no',
        'tms_shp_order_number',
        'tms_cus_id',
        'tms_brch_id',
        'tms_plnt_id',
        'tms_dep_id',
        'tms_vty_id',
        'tms_cpt_id',
        'tms_veh_id',
        'tms_shp_supplier_send_vehi_id',
        'tms_shp_supplier_billing_vehi_id',
        'tms_shp_mode',
        'tms_shp_qty_type',
        'tms_shp_delivery_qty',
        'vehi_allocated_qty',
        'vehi_utilization',
        'vehi_utilization_cbm',
        'vehi_utilization_weight',
        'tms_shp_request_date',
        'tms_shp_contact_person',
        'tms_shp_contact_no',
        'tms_shp_email',
        'tms_shp_trip_mode',
        'tms_shp_trip_type',
        'tms_shp_cus_commitment_type',
        'tms_shp_sup_trip_type',
        'tms_shp_sup_commitment_type',
        'tms_shp_pay_for',
        'tms_shp_shipment_type',
        'tms_shp_driver',
        'tms_shp_helper',
        'tms_shp_request_loc',
        'tms_shp_pickup_loc',
        'tms_shp_delivery_loc',
        'tms_shp_delivery_loc_dtype',
        'tms_shp_pickup_address',
        'tms_shp_delivery_address',
        'tms_shp_pickup_date',
        'tms_shp_pickup_time',
        'tms_shp_delivery_date',
        'tms_shp_delivery_time',
        'tms_shp_arrival_date',
        'tms_shp_arrival_time',
        'tms_shp_dispatch_date',
        'tms_shp_dispatch_time',
        'tms_shp_total_mileage',
        'tms_shp_estimated_mileage',
        'tms_shp_actial_trip_mileage',
        'tms_shp_trip_cost',
        'tms_total_trip_cost',
        'tms_shp_additional_cost_per',
        'tms_shp_demurrage_amount_customer',
        'tms_shp_other_amount',
        'tms_shp_consignee_buyer',
        'tms_shp_consignment_type',
        'tms_shp_import_no',
        'tms_shp_bl_no',
        'tms_shp_air_way_no',
        'tms_shp_reference',
        'tms_shp_security_no',
        'tms_shp_remarks',
        'tms_shp_dispute_remark',
        'tms_shp_status',
        'tms_shp_create_user',
        'tms_shp_create_date',
        'tms_ship_accepeted_user',
        'tms_ship_accepted_date',
        'tms_shp_approved_user',
        'tms_shp_approved_date',
        'isInvoice',
        'isSupplier_invoice',
        'tms_shp_arrived_pickup',
        'tms_shp_departed_pickup',
        'tms_shp_attended',
        'tms_shp_arrived_delivery',
        'tms_shp_departed_delivery',
        'tms_shp_arrived_delivery_temp',
        'tms_shp_departed_delivery_temp',
        'tms_shp_shipment_start',
        'tms_shp_shipment_end',
        'tms_shp_shipment_spend',
        'srm_supplier_id',
        'srm_commitment_km',
        'srm_rete_commitment_km',
        'srm_first_trip_rate',
        'srm_second_trip_rate',
        'tms_shp_supplier_rate',
        'srm_supplier_requested_rate',
        'tms_shp_supplier_trip_mode',
        'tms_shp_customer_trip_mode',
        'tms_shp_shipment_start_mileage',
        'tms_shp_shipment_end_mileage',
        'tms_shp_pickup_door_open',
        'tms_shp_pickup_door_close',
        'tms_shp_deliver_door_open',
        'tms_shp_deliver_door_close',
        'tms_shp_loading_charge',
        'tms_shp_highway_charge',
        'tms_shp_deductions',
        'tms_shp_night_bata',
        'tms_shp_gps_track',
        'tms_shp_cbm',
        'tms_shp_weight',
        'tms_shp_epod_report',
        'tms_shp_inv_no',
        'tms_shp_demurrage_amount_supplier',
        'tms_shp_demurrage_hrs',
        'tms_shp_demurrage_amount',
        'tms_shp_late_booking',
        'tms_shp_placement_status',
        'tms_shp_container_type',
        'tms_shp_container_number',
        'tms_shp_ref_po_number',
        'tms_shp_cut_off_date',
        'tms_shp_unloading_charge',
        'tms_shp_boi_charge',
        'tms_shp_shipment_doc',
        'tms_shp_cnt_doc',
        'tms_shp_attended_by',
        'tms_shp_arrived_at_pickup_by',
        'tms_shp_started_by',
        'tms_shp_completed_by',
        'tms_shp_SAP_REF',
        'tms_shp_isSAP_data_passed',
        'tms_shp_isSAP_customer_data_passed',
        'tms_shp_isSAP_supplier_data_passed',
        'tms_shp_supplier_night_bata',
        'tms_shp_supplier_highway',
        'tms_shp_supplier_loading',
        'tms_shp_supplier_unloading',
        'tms_shp_supplier_boi',
        'tms_shp_supplier_other_charges',
        'tms_shp_supplier_deduction',
        'tms_shp_send_to_csv',
        'tms_shp_route_id',
        'tms_ship_cargo_status',
        'tms_ship_attended_date',
        'tms_ship_canceled_date',
        'tms_shp_visited',
        'tms_shp_not_visited_reson',
        'tms_shp_priority',
        'delivery_priority',
        'tms_shp_estimated_in',
        'tms_shp_estimated_out',
        'tms_is_gate_pass_print',
        'tms_start_odometer',
        'tms_end_odometer',
        'tms_shp_driver_salary',
        'tms_shp_helper_salary',
        'tms_shp_pickup_in_datetime',
        'tms_shp_pickup_out_datetime',
        'status',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id', 'id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'tms_vty_id', 'veh_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'tms_cus_id', 'cus_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'tms_veh_id', 'veh_id');
    }

    public function pickupLocation()
    {
        return $this->belongsTo(Location::class, 'tms_shp_pickup_loc', 'loc_id');
    }

    public function deliveryLocation()
    {
        return $this->belongsTo(Location::class, 'tms_shp_delivery_loc', 'loc_id');
    }

    public function viaLocations()
    {
        return $this->hasMany(ViaLocation::class, 'tms_shipment_id', 'tms_shp_id');
    }

    public function driver()
    {
        return $this->belongsTo(Employee::class, 'tms_shp_driver', 'emp_id');
    }
}