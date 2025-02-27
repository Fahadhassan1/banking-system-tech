<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
            'accounts' => 'required|array|min:1', 
            'accounts.*.fname' => 'required|string|max:255',
            'accounts.*.lname' => 'required|string|max:255',
            'accounts.*.dob' => 'required|date',
            'accounts.*.address' => 'required|string',
            'accounts.*.phone' => 'required|string',
            'accounts.*.currency' => 'required|in:USD,GBP,EUR',
            'accounts.*.user_id' => 'required|exists:users,id|distinct',
            'accounts.*.balance' => 'required|numeric',
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'accounts.required' => 'At least one account must be provided.',
            'accounts.array' => 'Accounts should be an array.',
            'accounts.min' => 'At least one account is required.',

            'accounts.*.fname.required' => 'First name is required.',
            'accounts.*.fname.string' => 'First name must be a valid string.',
            'accounts.*.fname.max' => 'First name cannot exceed 255 characters.',

            'accounts.*.lname.required' => 'Last name is required.',
            'accounts.*.lname.string' => 'Last name must be a valid string.',
            'accounts.*.lname.max' => 'Last name cannot exceed 255 characters.',

            'accounts.*.dob.required' => 'Date of birth is required.',
            'accounts.*.dob.date' => 'Date of birth must be a valid date.',

            'accounts.*.address.required' => 'Address is required.',
            'accounts.*.address.string' => 'Address must be a valid string.',

            'accounts.*.phone.required' => 'Phone number is required.',
            'accounts.*.phone.string' => 'Phone number must be a valid string.',

            'accounts.*.currency.required' => 'Currency is required.',
            'accounts.*.currency.in' => 'Currency must be one of the following: USD, GBP, EUR.',

            'accounts.*.user_id.required' => 'User ID is required.',
            'accounts.*.user_id.exists' => 'The selected user ID does not exist.',
            'accounts.*.user_id.distinct' => 'Each account must have a unique user ID, You cant open duplicate account for same user.',

            'accounts.*.balance.required' => 'Balance is required.',
            'accounts.*.balance.numeric' => 'Balance must be a valid number.',
        ];
    }
}
