<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom error messages for validator rules.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'The transaction type field is required.',
            'type.in' => 'The transaction type must be either income or expense.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a numeric value.',
            'amount.min' => 'The amount must be at least 0.01.',
            'description.string' => 'The description must be a string.',
        ];
    }
}
