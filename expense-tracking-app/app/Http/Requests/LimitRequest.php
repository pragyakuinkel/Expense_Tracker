<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LimitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limits.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'new_limits.*' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function attributes(): array{
        return [
            'limits.*' => 'limit',
            'new_limits.*' => 'limit',
        ];
    }
}
