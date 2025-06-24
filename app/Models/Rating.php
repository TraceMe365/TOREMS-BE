<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'tms_rating';

    protected $fillable = [
        'shipment_id',
        'customer_id',
        'rating',
        'comment',
        'employee_id', // Add this if you want to store employee reference
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'tms_shp_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'cus_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }
}