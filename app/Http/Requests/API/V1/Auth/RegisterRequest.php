<?php

namespace App\Http\Requests\API\V1\Auth;

use App\Enums\Models\UserRolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'role' => [
                'required',
                'string',
                new Enum(UserRolesEnum::class),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'role.enum' => 'There is no such role.',
        ];
    }
}
