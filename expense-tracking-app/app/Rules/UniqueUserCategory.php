<?php

namespace App\Rules;

use App\Models\Category;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class UniqueUserCategory implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $category = Category::where('name', $value)->whereHas('users', function ($query) {
            $query->where('id',Auth::id())->whereMonth('date', Carbon::parse(request('date'))->month)->whereYear('date', Carbon::parse(request('date'))->year);
        })->exists();

        if ($category) {
            $fail('The :attribute already exists.');
        }
    }
}
