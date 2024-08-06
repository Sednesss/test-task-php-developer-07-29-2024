<?php

namespace App\Http\Requests\API\V1\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
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
                'string'
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
                'string'
            ],
            'phone' => [
                'nullable',
                'string'
            ],
            'date_of_birth' => [
                'nullable',
                'date'
            ],
            'address' => [
                'nullable',
                'string'
            ],

        ];
    }
}
