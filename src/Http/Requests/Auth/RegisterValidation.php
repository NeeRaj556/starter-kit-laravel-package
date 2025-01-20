<?php

namespace Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use App\Http\Requests\BaseRequestValidation;
use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],

        ];
    }
}
