<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
        'gender',
        'address',
        'age',
        'dob',
        'employ_type',
        'salary',
        'date',
        'total_leaves',
        'pt',
        'pt_percentage',
        'job_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date' => 'date',
        'dob' => 'date',
        'employ_type' => 'boolean',
        'pt' => 'boolean',
    ];

    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function fees(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Fee::class, 'collected_by');
    }

    public function memberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function scopeSalary(Builder $builder, $bool): Builder
    {
        return $builder->where('employ_type', $bool);
    }

    public function scopePt(Builder $builder, $bool): Builder
    {
        return $builder->where('pt', $bool);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function userAttendances(): HasMany
    {
        return $this->hasMany(UserAttendance::class);
    }

    public function shifts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Shift::class, 'user_shift')->withTimestamps();
    }

    // personal training members
    public function ptMembers()
    {
        return $this->hasMany(Member::class, 'trainer_id');
    }

    public function feeLogs()
    {
        return $this->hasMany(FeeLog::class);
    }
    // the user who create member
    public function memberCreate()
    {
        return $this->hasMany(Member::class,'created_by');
    }
}
