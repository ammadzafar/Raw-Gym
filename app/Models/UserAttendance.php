<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserAttendance extends Model
{
    protected $fillable = [
            'user_id',
            'status',
            'label',
            'admin_approval',
            'ip',
            'device',
            'shift_time',
            'clock_in',
            'clock_out',

        ];
    protected $casts = [
        'shift_time' => 'datetime',
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
    ];

    public function scopeapproval(Builder $builder, $bool)
    {
        $builder->where('admin_approval', $bool);

    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    /*public function scopeStatusChange($status, $approval)
    {
        $statusArray = ['absent', 'leave'];
        $this->status = $status;
        $this->admin_approval =$approval;
        dd($this);
        if (in_array($status, $statusArray) && $approval) {
            $this->user->total_leaves = $this->user->total_leaves - 1;
        } else {
            $this->user->total_leaves = $this->user->total_leaves + 1;
        }
        $this->save();
    }*/
}
