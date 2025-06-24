<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'tms_vehicle';
    protected $primaryKey = 'veh_id';

    protected $fillable = [
        'veh_no',
        'veh_shr_mode',
        'cus_sup_id',
        'veh_uniq_id',
        'supplier_id',
        'vehicle_type',
        'veh_loading_capacity',
        'veh_eng_no',
        'veh_chassis',
        'veh_f_reg_date',
        'veh_ins_ren_date',
        'veh_lic_ren_date',
        'veh_status',
        'veh_availability',
        'veh_daily_shipmenmt_count',
        'tms_veh_turnaround_time',
        'veh_gps_status',
        'veh_permanent',
        'created_by',
        'veh_diver_id',
        'veh_hepler_id',
        'veh_image_link',
        'veh_ot_duration',
        'veh_ot_rate',
        'veh_ot_rate_sup',
        'gs_object_id',
        'customer_id',
        'veh_vehicle_mode',
        'veh_is_available',
        'veh_insurance_expiry',
        'veh_emission_expiry',
        'veh_revenue_expiry',
        'veh_registration_expiry',
        'veh_license_expiry',
    ];
}