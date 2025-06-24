<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRateMasterPointToPointRate extends Model
{
    protected $table = 'tms_customer_rate_master_p_to_p';
    protected $primaryKey = 'cus_ptop_id';

    protected $fillable = [
        'cus_rate_id',
        'ptop_id',
        'total_rate',
        'aditional_cost_km',
        'free_demurrage_less',
        'free_demurrage_more',
        'after_free_demurrage',
        'after_free_demurrage_48',
    ];
}