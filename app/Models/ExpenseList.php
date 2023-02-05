<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseList extends Model
{
    //
    protected $table = 'expense_lists';
    protected $fillable = [
        'expense_id',
        'label',
        'amount',
        'status',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class , 'expense_id' , 'id');
    }
}
