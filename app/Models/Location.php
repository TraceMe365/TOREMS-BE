<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'tms_location';
    protected $primaryKey = 'loc_id';

    protected $fillable = [
        'tms_are_id',
        'loc_code',
        'loc_sap_code',
        'cus_sup_id',
        'loc_resourse',
        'loc_uniq_id',
        'cus_id',
        'loc_name',
        'loc_address',
        'loc_other',
        'loc_type',
        'loc_status',
        'loc_turn_around_time',
        'loc_lat',
        'loc_long',
        'created_by',
        'loc_contact_person',
        'loc_contact_mobile',
        'loc_contact_other',
        'loc_priority_level',
        'loc_distance',
        'loc_excess_calculate',
        'loc_loading_charge',
        'loc_vehi_mode',
        'loc_vehi_type',
        'loc_city_id',
        'filled',
        'loc_sap_cost_center',
        'loc_sap_purchase_group',
        'loc_sap_branch_id',
        'loc_sync_timestamp',
        'is_recorrect_loc',
        'is_with_geofence',
    ];
}