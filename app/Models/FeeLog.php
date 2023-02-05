<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeLog extends Model
{
    protected $fillable =[
        'user_id',
        'member_id',
        'fees',
        'updated_by'

    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsTo(Member::class);
    }
}
