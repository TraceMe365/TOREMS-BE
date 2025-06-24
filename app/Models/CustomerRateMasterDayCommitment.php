<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRateMasterDayCommitment extends Model
{
    protected $table = 'tms_customer_rate_master_day_commitment';
    protected $primaryKey = 'tms_crd_id';

    protected $fillable = [
        'cus_rate_id',
        'tms_crd_minimum_km',
        'tms_crd_commitment_rate',
        'tms_crd_excess_rate_per_km',
        'tms_crd_trip_per_day',
    ];
}