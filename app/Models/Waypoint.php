<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waypoint extends Model
{
    protected $table = 'tms_waypoints';

    protected $fillable = [
        'shipment_id',
        'latitude',
        'longitude',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'tms_shp_id');
    }
}
