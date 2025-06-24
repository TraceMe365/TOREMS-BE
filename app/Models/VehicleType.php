<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table = 'tms_vehicle_type';
    protected $primaryKey = 'veh_type_id';

    protected $fillable = [
        'veh_type',
        'veh_type_specification',
        'veh_efficiency',
        'veh_type_status',
        'created_by',
        'tms_com_id',
        'tms_cus_id',
        'veh_capacity',
        'veh_id', // Foreign key to tms_vehicle
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'veh_id', 'veh_id');
    }
}