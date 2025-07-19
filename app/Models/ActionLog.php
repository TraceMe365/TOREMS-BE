<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $fillable = [
        'action',
        'controller',
        'method',
        'user_id',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
