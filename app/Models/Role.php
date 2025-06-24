<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'tms_role';

    protected $fillable = [
        'name',
        'status',
        'description',
        'slug',
    ];
}