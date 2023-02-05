<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IhtfLog extends Model
{
    protected $guarded = ['id'];

    public function inHouseMembers()
    {
        return $this->belongsTo(Member::class);

    }
    public function inHouseUsers()
    {
        return $this->belongsTo(User::class);
    }
}
