<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable=['name','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('limit','date');
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
