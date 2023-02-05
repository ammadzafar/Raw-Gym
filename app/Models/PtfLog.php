<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PtfLog extends Model
{

    protected $fillable =
[
    'member_id',
    'user_id',
    'updated_by',
    'personal_training_fees'
];
    public function members()
    {
        return $this->belongsTo(Member::class);

    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
