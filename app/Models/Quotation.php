<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'tms_quotation';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'quotation_no',
        'quotation_date',
        'origin',
        'origin_latitude',
        'origin_longitude',
        'destination',
        'destination_latitude',
        'destination_longitude',
        'vehicle_type',
        'rate',
        'rate_type',
        'estimated_distance',
        'estimated_time',
        'remarks',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'cus_id');
    }
}