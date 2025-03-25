<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CreateStatement
{
    public function statements(): MorphMany
    {
        return $this->morphMany(CreateStatement::class, 'statementable');
    }
}
