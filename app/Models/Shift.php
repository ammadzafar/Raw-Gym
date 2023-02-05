<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable =
        [
            'name',
            'from',
            'to'
        ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_shift');
    }
}
