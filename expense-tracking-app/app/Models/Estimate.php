<?php

namespace App\Models;

use App\Traits\CreateLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Estimate extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'date',
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
