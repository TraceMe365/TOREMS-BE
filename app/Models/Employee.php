<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'tms_employee';
    protected $primaryKey = 'emp_id';

    protected $fillable = [
        'sup_id',
        'tms_com_id',
        'tms_cus_id',
        'cus_sup_id',
        'emp_f_name',
        'emp_s_name',
        'emp_address',
        'emp_id_card',
        'emp_licence_card',
        'emp_mobile',
        'emp_home',
        'emp_type',
        'emp_status',
        'created_by',
        'emp_doc_link',
        'emp_pic_link',
        'gs_object_id',
        'emp_is_authenticated',
        'emp_last_activity',
        'emp_otp',
        'emp_device_mac',
        'emp_token',
        'emp_firebase_token',
        'employee_license_expiry',
        'emp_license_expiry',
        'emp_police_expiry',
        'emp_password',
        'emp_grama_expiry',
    ];
}