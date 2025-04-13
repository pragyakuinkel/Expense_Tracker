<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'logable');
    }
}
