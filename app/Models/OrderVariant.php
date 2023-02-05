<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderVariant extends Model
{
    protected $table = 'order_variant';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'variant_id',
        'order_id',
        'quantity',
        'unit_price',
        'total_amount',
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
