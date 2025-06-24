<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'tms_menu';

    protected $primaryKey = 'id';

    protected $fillable = [
        'tms_menu_icon',
        'tms_menu_name',
        'tms_menu_route',
        'tms_menu_order',
        'tms_menu_package',
        'tms_menu_parent',
        'tms_menu_status',
    ];

    public $timestamps = false;

    
}