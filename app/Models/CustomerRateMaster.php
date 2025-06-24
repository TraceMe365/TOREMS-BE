<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRateMaster extends Model
{
    protected $table = 'tms_customer_rate_master';
    protected $primaryKey = 'cus_rate_id';

    protected $fillable = [
        'customer_id',
        'veh_type_id',
        'capacity_id',
        'type_of_rates',
        'created_by',
        'rate_request_status',
        'rate_request_conf_by_user_id',
        'rate_submited_by',
        'rate_requested_date',
        'rate_request_conf_date',
        'cms_status',
        'commitment_type',
        'demurrage_type',
        'demurrage_hrs',
        'demurrage_cost',
        'exceed_km_rate',
        'exceed_per_km_rate',
        'loading_only',
        'first_trip_rate',
        'second_trip_rate',
        'commitment_km',
    ];
}