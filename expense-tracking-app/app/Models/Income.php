<?php

namespace App\Models;

use App\Traits\CreateLog;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use CreateLog;
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
