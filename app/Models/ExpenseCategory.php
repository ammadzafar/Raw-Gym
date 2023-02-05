<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $guarded = ['id'];

    public function expenseIndi()
    {
        return $this->hasOne(Expense::class,'category_id','id');
    }
}
