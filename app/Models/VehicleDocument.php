<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDocument extends Model
{
    protected $table = 'tms_vehicle_document';
    protected $primaryKey = 'id';

    protected $fillable = [
        'veh_id',
        'file_name',
        'file_path',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'veh_id', 'veh_id');
    }
}