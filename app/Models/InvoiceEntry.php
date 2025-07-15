<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceEntry extends Model
{
    protected $table = 'tms_trip_invoice_entry';
    protected $primaryKey = 'tms_ien_id';

    protected $fillable = [
        'tms_inv_id',
        'tms_ien_request_id',
        'tms_ien_request_date',
        'tms_ien_pickup_location',
        'tms_ien_dropoff_location',
        'tms_ien_trip_start',
        'tms_ien_trip_end',
        'tms_ien_trip_spend',
        'tms_ien_delivery',
        'tms_ien_demurrage',
        'tms_ien_other',
        'tms_ien_loading',
        'tms_ien_night_bata',
        'tms_ien_trip_type',
        'tms_ien_deduction',
        'tms_trip_km',
        'tms_ien_vehi_id',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'tms_inv_id', 'tms_inv_id');
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'tms_ien_request_id', 'tms_shp_id');
    }
}