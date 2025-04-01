<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CreateLog
{
    public function logs(): MorphMany
    {
        return $this->morphMany(CreateLog::class, 'logable');
    }
}
