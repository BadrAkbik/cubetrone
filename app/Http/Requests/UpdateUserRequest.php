<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'first_name' => ['string', 'min:2'],
            'last_name' => ['string', 'min:2'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'date_of_birth' => ['date'],
            'gender' => ['in:male,female'],
            'phone_num' => ['regex:^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$^'],
            'password' => ['confirmed', Password::defaults()]
        ];
    }
}
