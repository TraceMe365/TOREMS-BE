<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    protected $table = 'tms_employee_document';

    protected $fillable = [
        'employee_id',
        'document_type',
        'document_name',
        'document_path',
        'expiry_date',
        'remarks',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'emp_id');
    }
}