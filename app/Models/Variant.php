<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'price',
        'sku',
        'stock',
        'status',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function values(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Value::class)->withTimestamps();
    }

    public function orderDetails()
    {
        return $this->belongsToMany(Variant::class, 'order_variant')->withPivot('quantity', 'unit_price', 'total_amount')->withTimestamps();
    }
}
