<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterLog extends Model
{
    protected $fillable=
        [
            'user_id',
            'member_id',
            'updated_by',
            'created_at',
            'reg_fee',
            'reg_date'

            ];
    protected $casts =
        [
            'reg_date'=>'datetime'
        ];
 public function members()
 {
     return $this->belongsTo(Member::class);
 }
 public function users()
 {
     return $this->belongsTo(User::class);
 }
}
