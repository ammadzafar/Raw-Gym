<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'order_at',
        'status',
        'comment',
        'address',
    ];

    protected $casts = [
        'order_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Member::class);
    }

    public function orderDetails()
    {
        return $this->belongsToMany(Variant::class, 'order_variant')->withPivot('quantity', 'unit_price', 'total_amount')->withTimestamps();
    }
}
