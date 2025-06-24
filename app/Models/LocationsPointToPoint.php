<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationsPointToPoint extends Model
{
    protected $table = 'tms_locations_p_to_p';
    protected $primaryKey = 'ptop_id';

    protected $fillable = [
        'cus_id',
        'pickup_location',
        'drop_off_location',
        'total_mileage',
        'title',
        'created_by',
        'ptop_status',
    ];

    public function pickupLocation()
    {
        return $this->belongsTo(Location::class, 'pickup_location', 'loc_id');
    }

    public function dropOffLocation()
    {
        return $this->belongsTo(Location::class, 'drop_off_location', 'loc_id');
    }
}