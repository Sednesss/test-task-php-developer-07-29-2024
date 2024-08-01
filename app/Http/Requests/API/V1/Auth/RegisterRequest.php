<?php

namespace App\Http\Requests\API\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'unique:App\Models\User,name'
            ],
            'first_name' => [
                'required',
                'string',
                'nullable'
            ],
            'last_name' => [
                'required',
                'string',
                'nullable'
            ],
            'father_name' => [
                'required',
                'string',
                'nullable'
            ],
            'email' => [
                'required',
                'string',
                'unique:App\Models\User,email'
            ],
            'password' => [
                'required',
                'string',
                'min:4',
                'confirmed'
            ],
        ];
    }
}
