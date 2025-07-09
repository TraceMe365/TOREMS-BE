<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    protected $table = 'tms_company';

    protected $fillable = [
        'company_name',
        'address',
        'contact',
        'email',
        'website',
        'business_registration_code',
        'company_vat_number',
        'image_path'
    ];
}
