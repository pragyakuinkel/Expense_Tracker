<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['name','role_id'];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)
            ->withPivot('limit','date');
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
