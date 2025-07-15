<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'tms_trip_invoice';
    protected $primaryKey = 'tms_inv_id';

    protected $fillable = [
        'tms_cus_id',
        'tms_brch_id',
        'tms_inv_no',
        'tms_inv_date',
        'tms_inv_mode',
        'tms_inv_type',
        'tms_inv_total_delivery',
        'tms_inv_total_demurrage',
        'tms_inv_total_other',
        'tms_inv_total_deductions',
        'tms_inv_total_loading',
        'tms_inv_total_night_bata',
        'tms_inv_net_amount',
        'tms_inv_status',
        'tms_inv_create_user',
        'tms_inv_create_date',
        'tms_inv_processed_user',
        'tms_inv_processed_date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'tms_cus_id', 'cus_id');
    }

    public function entries()
    {
        return $this->hasMany(InvoiceEntry::class, 'tms_inv_id', 'tms_inv_id');
    }
}