<?php

namespace App\Models;

use Illuminate\Cache\Lock;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'membership_id',
        'name',
        'phone',
        'email',
        'image',
        'gender',
        'address',
        'age',
        'dob',
        'status',
        'reg_fee',
        'fee_structure',
        'is_expired',
        'personal_training_fees',
        'personal_training',
        'in_house_training_fees',
        'in_house_training',
        'created_at',
        'exercise_type',
        'roll_number',
        'trainer_id',
        'created_by',
        'is_member',
        'expired_at',
        'guest_member',
        'classes_fees'

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'dob' => 'datetime',
        'is_member' => 'boolean',
        'expired_at' => 'datetime',
        'guest_member'=>'boolean',
    ];

    public function fees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function membership(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    public function attendances(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function locker(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Locker::class);
    }

    public function trainer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function scopeActive(Builder $builder, $bool)
    {
        $builder->where('status', $bool);
    }

    public function scopeExpire(Builder $builder, $bool)
    {
        $builder->where('is_expired', $bool);
    }

    public function scopePersonalTraining(Builder $builder, $bool)
    {
        $builder->where('personal_training', $bool);
    }

    public function feeLogs()
    {
        return $this->hasMany(FeeLog::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registerLogs()
    {
        return $this->hasMany(RegisterLog::class);
    }

    public function ptfLogs()
    {
        return $this->hasMany(PtfLog::class);
    }
    public function inhtfLogs()
    {
        return $this->hasMany(IhtfLog::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function wishlist(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->HasMany(Wishlist::class, 'customer_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Clas::class,'clas_members','member_id','clas_id');
    }

}
