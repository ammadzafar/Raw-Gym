<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable =
        [
            'consultant_id',
            'subject',
            'message'
        ];

    public function consultant()
    {
        return $this->belongsTo(Consultant::class);
    }
}
