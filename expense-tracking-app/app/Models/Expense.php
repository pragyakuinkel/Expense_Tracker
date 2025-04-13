<?php

namespace App\Models;

use App\Traits\CreateLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'category_id',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'logable');
    }
}
