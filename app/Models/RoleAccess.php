<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleAccess extends Model
{
    protected $table = 'tms_role_access';
    protected $primaryKey = 'id';

    protected $fillable = [
        'role_id',
        'function_name',
        'access_level',
        'user_id', // Add this if you want to store user reference
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}