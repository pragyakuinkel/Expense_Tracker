<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
