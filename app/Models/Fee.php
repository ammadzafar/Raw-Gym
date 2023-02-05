<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'collected_by',
        'member_id',
        'membership_id',
        'fees',
        'discount',
        'reg_fee',
        'total_payment',
        'pending_fees',
        'personal_training_fees',
        'in_house_training_fees',
        'pending_personal_training_fees',
        'payment_method',
        'expire_date',
        'payment_date',
        'payment_month',
        'status',
        'notes',
        'reg_date',
        'date',
        'extra_charges',
        'classes_fees',
    ];

    protected $casts = [
        'expire_date' => 'datetime',
        'payment_date' => 'datetime',
        'reg_date'=>'datetime'
    ];

    public function collectedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'collected_by');
    }

    public function member(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function membership(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Membership::class,'membership_id','id');
    }
}
