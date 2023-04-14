<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiFormRequest;

class RegisterRequest extends ApiFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed'
        ];
    }
}
