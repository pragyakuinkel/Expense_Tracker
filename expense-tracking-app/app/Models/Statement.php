<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    protected $table = 'statements';

    protected $fillable = [
        'amount',
        'statementable_id',
        'statementable_type',
        'user_id',
        'date',
        'action'
    ];

    public function statementable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
