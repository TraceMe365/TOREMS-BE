<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRateMasterSlabRate extends Model
{
    protected $table = 'tms_customer_rate_master_slab';
    protected $primaryKey = 'cus_slab_rate_id';

    protected $fillable = [
        'cus_rate_id',
        'cus_slab_minimum_km',
        'cus_slab_fixed_rate',
        'cus_slab_1st_slab',
        'cus_slab_2nd_slab',
        'cus_slab_3rd_slab',
        'cus_slab_dem_less_free_hrs',
        'cus_slab_dem_less_rate',
        'cus_slab_dem_more_free_hrs',
        'cus_slab_dem_more_rate',
    ];
}