<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tms_customer';
    protected $primaryKey = 'cus_id';

    protected $fillable = [
        'cus_code',
        'cus_name',
        'cus_address',
        'cus_con_person',
        'cus_con_person_num',
        'cus_con_person_email',
        'cus_other_details',
        'cus_status',
        'created_by',
        'tms_package',
        'tms_com_id',
        'start_loc_type',
        'end_loc_type',
        'aditional_mileage_pre',
        'cus_vat_number',
        'cus_nbt_number',
    ];
}