<?php

namespace App\Http\Requests;

use App\Rules\FutureDate;
use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
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
            'amount' => 'required|numeric|min:0|regex:/^\d{1,13}(\.\d{1,4})?$/',
            'date' => ['required','date'],
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return ['amount.regex'=>'Amount must have up to 13 digits before and up to 4 digits after the decimal point.'];
    }
}
