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
        'approve_user_id',
        'approve_time',
        'origin_id',
        'destination_id',

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'cus_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type', 'veh_type_id');
    }

    public function viaLocations()
    {
        return $this->hasMany(ViaLocation::class, 'tms_quotation_id', 'id');
    }
}