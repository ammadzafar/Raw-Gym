<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    //
    protected $table = 'expenses';
    protected $fillable = [
        'date',
        'status',
        'category_id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function expenseList()
    {
        return $this->hasMany(ExpenseList::class, 'expense_id', 'id');
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class,'category_id','id');
    }
}
