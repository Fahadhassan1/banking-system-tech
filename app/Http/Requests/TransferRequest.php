<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true if all users can perform this request
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'recipient_account_number' => 'required|exists:accounts,account_number',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|in:USD,GBP,EUR',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'recipient_account_number.required' => 'Recipient account number is required.',
            'recipient_account_number.exists' => 'The recipient account number does not exist.',

            'amount.required' => 'Amount is required.',
            'amount.numeric' => 'Amount must be a valid number.',
            'amount.min' => 'Amount must be at least 1.',

            'currency.required' => 'Currency is required.',
            'currency.in' => 'Currency must be one of: USD, GBP, EUR.',

            'description.string' => 'Description must be a valid string.',
        ];
   
    }
}
