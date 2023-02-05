<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $fillable =
        [
            'name',
            'email',
            'mobile'
        ];

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }
}
