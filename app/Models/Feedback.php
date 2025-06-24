<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'tms_feedback';
    protected $primaryKey = 'id';

    protected $fillable = [
        'shipment_id',
        'customer_id',
        'rating',
        'comment',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'tms_shp_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'cus_id');
    }
}