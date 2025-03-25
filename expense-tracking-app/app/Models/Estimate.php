<?php

namespace App\Models;

use App\Traits\CreateStatement;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use CreateStatement;

    protected $fillable = [
        'user_id',
        'amount',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
