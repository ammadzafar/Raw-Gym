<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    //
    protected $fillable =
        [
            'name',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'


        ];
    protected $casts=
        [
            'Monday'=>'boolean',
            'Tuesday'=>'boolean',
            'Wednesday'=>'boolean',
            'Thursday'=>'boolean',
            'Friday'=>'boolean',
            'Saturday'=>'boolean',
            'Sunday'=>'boolean'
        ];
    public function scopeDays(Builder $builder, $bool)
    {
        $builder->where(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'], $bool);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class,'clas_members','clas_id','member_id');
    }
}
