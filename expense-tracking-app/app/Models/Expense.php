<?php

namespace App\Models;

use App\Traits\CreateLog;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use CreateLog;

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
}
