<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'fees',
        'reg_fee',
        'duration',
        'membership_type',
        'status',
        'featured',
        'description'
    ];

    public function scopeActive(Builder $builder, $bool)
    {
        $builder->where('status', $bool);

    }
    public function scopeFeatured(Builder $builder ,$bool)
    {
        $builder->where('featured',$bool);
    }

    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function fees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Fee::class,'membership_id','id');
    }
}
