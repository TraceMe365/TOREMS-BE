<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViaLocation extends Model
{
    protected $table = 'tms_via_location';

    protected $fillable = [
        'tms_shipment_id',
        'via_location',
        'via_latitude',
        'via_longitude',
        'tms_quotation_id',
        'location_id',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'tms_shipment_id', 'tms_shp_id');
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'tms_quotation_id', 'id');
    }
}