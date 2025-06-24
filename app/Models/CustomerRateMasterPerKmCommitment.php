<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRateMasterPerKmCommitment extends Model
{
    protected $table = 'tms_customer_rate_master_per_km';
    protected $primaryKey = 'per_km_id';

    protected $fillable = [
        'cus_rate_id',
        'minimum_km',
        'minimum_km_rate',
        'minimum_km_rate_after',
        'free_demurrage_less',
        'free_demurrage_more',
        'after_free_demurrage',
        'day_trip_count',
    ];
}